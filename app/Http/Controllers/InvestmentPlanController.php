<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;
use App\Models\UserPackage;
use Illuminate\Support\Facades\Auth;

class InvestmentPlanController extends Controller
{
    public function index()
    {
        $plans = Package::where('is_active', true)->orderBy('price')->get();
        $user = Auth::user();

        $eligibleStatuses = ['pending', 'active_waiting', 'active', 'expired'];
        $latestOwnedPackage = $user
            ? $user->userPackages()->whereIn('status', $eligibleStatuses)->latest()->first()
            : null;

        $currentPackagePrice = $latestOwnedPackage
            ? Package::whereKey($latestOwnedPackage->package_id)->value('price')
            : null;

        $hasAnyPackage = $user
            ? $user->userPackages()->whereIn('status', $eligibleStatuses)->exists()
            : false;

        $recommendedPlanId = $plans->firstWhere('is_recommended', true)?->id;

        return view('customer.investment-plans', [
            'plans' => $plans,
            'hasAnyPackage' => $hasAnyPackage,
            'currentPackageId' => $latestOwnedPackage?->package_id,
            'currentPackagePrice' => $currentPackagePrice,
            'recommendedPlanId' => $recommendedPlanId,
        ]);
    }

    public function requestForm(Package $package)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $selectedPackage = Package::where('is_active', true)->findOrFail($package->id);

        $planOptions = Package::where('is_active', true)
            ->orderBy('price')
            ->pluck('name', 'id');

        $latestStatus = $user->userPackages()
            ->whereIn('status', ['pending', 'active_waiting', 'active', 'expired'])
            ->latest()
            ->value('status');

        // Get existing package data for pre-filling form during upgrade/downgrade
        $existingPackage = $user->userPackages()
            ->whereIn('status', ['pending', 'active_waiting', 'active', 'expired'])
            ->latest()
            ->first();

        return view('customer.plan-request', [
            'selectedPackage' => $selectedPackage,
            'planOptions' => $planOptions,
            'latestStatus' => $latestStatus,
            'existingPackage' => $existingPackage,
        ]);
    }

    public function submitRequest(Request $request, Package $package)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $validated = $request->validate([
            'broker_name' => ['required', 'string', 'max:255'],
            'trading_id' => ['required', 'string', 'max:255'],
            'trading_password' => ['required', 'string', 'max:255'],
            'trading_server' => ['required', 'string', 'max:255'],
            'package_id' => ['required', 'integer', 'exists:packages,id'],
            'equity' => ['nullable', 'numeric', 'min:0'],
        ]);

        $selectedPackage = Package::where('is_active', true)->find($validated['package_id']);

        if (! $selectedPackage) {
            return back()->withErrors(['package_id' => 'Selected package is not available.'])->withInput();
        }

        $currentPackage = $user->userPackages()
            ->whereIn('status', ['pending', 'active_waiting', 'active', 'expired'])
            ->latest()
            ->first();

        if ($currentPackage) {
            $currentPackage->update([
                'package_id' => $selectedPackage->id,
                'broker_name' => $validated['broker_name'],
                'trading_id' => $validated['trading_id'],
                'trading_password' => $validated['trading_password'],
                'trading_server' => $validated['trading_server'],
                'equity' => $validated['equity'] ?? null,
                'starts_at' => null,
                'ends_at' => null,
                'status' => 'pending',
            ]);
        } else {
            UserPackage::create([
                'user_id' => $user->id,
                'package_id' => $selectedPackage->id,
                'broker_name' => $validated['broker_name'],
                'trading_id' => $validated['trading_id'],
                'trading_password' => $validated['trading_password'],
                'trading_server' => $validated['trading_server'],
                'equity' => $validated['equity'] ?? null,
                'starts_at' => null,
                'ends_at' => null,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('my-plans')->with('success', 'Plan request submitted successfully. Waiting for admin verification.');
    }
}
