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

    public function submitDetailsShortcut()
    {
        $recommendedPackage = Package::where('is_active', true)
            ->where('is_recommended', true)
            ->orderBy('price')
            ->first();

        if (! $recommendedPackage) {
            $recommendedPackage = Package::where('is_active', true)
                ->orderBy('price')
                ->first();
        }

        if (! $recommendedPackage) {
            return redirect()
                ->route('investment-plans')
                ->with('error', 'No active package is available right now.');
        }

        return redirect()->route('investment-plans.request', $recommendedPackage);
    }

    public function requestForm(Package $package)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $eligibleStatuses = ['pending', 'active_waiting', 'active', 'expired'];

        $selectedPackage = Package::where('is_active', true)->findOrFail($package->id);

        $activePlans = Package::where('is_active', true)
            ->orderBy('price')
            ->get();

        $planOptions = $activePlans->pluck('name', 'id');

        $accountStatus = (string) $user->account_status;

        // Get existing package data for pre-filling form during upgrade/downgrade
        $existingPackage = $user->userPackages()
            ->whereIn('status', $eligibleStatuses)
            ->latest()
            ->first();

        $latestPackageRecordsByPackage = $user->userPackages()
            ->whereIn('status', $eligibleStatuses)
            ->whereNotNull('package_id')
            ->orderByDesc('updated_at')
            ->orderByDesc('id')
            ->get()
            ->groupBy('package_id')
            ->map(fn ($items) => $items->first());

        $planMeta = $activePlans->mapWithKeys(function (Package $plan) use ($latestPackageRecordsByPackage) {
            $packageRecord = $latestPackageRecordsByPackage->get($plan->id);

            return [
                $plan->id => [
                    'id' => (int) $plan->id,
                    'name' => (string) $plan->name,
                    'price' => (float) $plan->price,
                    'duration_label' => (string) $plan->duration_label,
                    'description' => (string) ($plan->description ?? ''),
                    'is_recommended' => (bool) $plan->is_recommended,
                    'facilities' => is_array($plan->facilities) ? array_values($plan->facilities) : [],
                    'status' => (string) ($packageRecord?->status ?? ''),
                    'broker_name' => (string) ($packageRecord?->broker_name ?? ''),
                    'trading_id' => (string) ($packageRecord?->trading_id ?? ''),
                    'trading_server' => (string) ($packageRecord?->trading_server ?? ''),
                    'equity' => $packageRecord?->equity !== null ? (float) $packageRecord->equity : null,
                ],
            ];
        });

        return view('customer.plan-request', [
            'selectedPackage' => $selectedPackage,
            'planOptions' => $planOptions,
            'planMeta' => $planMeta,
            'accountStatus' => $accountStatus,
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

        $minDeposit = (float) $selectedPackage->price;
        $equity = $validated['equity'] ?? null;

        if ($equity === null || $equity === '') {
            $equity = $minDeposit;
        }

        if ((float) $equity < $minDeposit) {
            return back()
                ->withErrors([
                    'equity' => 'Account equity cannot be less than the selected package minimum deposit of $' . number_format($minDeposit, 2) . '.',
                ])
                ->withInput();
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
                'equity' => $equity,
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
                'equity' => $equity,
                'starts_at' => null,
                'ends_at' => null,
                'status' => 'pending',
            ]);
        }

        return redirect()->route('my-plans')->with('success', 'Plan request submitted successfully. Waiting for admin verification.');
    }
}
