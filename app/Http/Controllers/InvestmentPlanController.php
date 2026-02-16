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

        return view('customer.investment-plans', [
            'plans' => $plans,
        ]);
    }

    public function activate(Request $request, Package $package)
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Create user package
        $startsAt = now();
        $endsAt = $startsAt->copy()->addDays($package->duration_days ?? 30);

        $userPackage = UserPackage::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => 'active',
        ]);

        return redirect()->route('my-plans')->with('success', 'Package activated successfully.');
    }
}
