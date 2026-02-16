<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserPackage;
use Illuminate\Support\Facades\Auth;

class CustomerPackageController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $userPackages = $user ? $user->userPackages()->with('package')->orderByDesc('starts_at')->get() : collect();

        return view('customer.my-plans', [
            'userPackages' => $userPackages,
        ]);
    }

    public function cancel(Request $request, UserPackage $userPackage)
    {
        $user = $request->user();

        if (! $user || $user->id !== $userPackage->user_id) {
            abort(403);
        }

        $userPackage->status = 'cancelled';
        $userPackage->ends_at = now();
        $userPackage->save();

        return redirect()->route('my-plans')->with('success', 'Package cancelled.');
    }

    public function renew(Request $request, UserPackage $userPackage)
    {
        $user = $request->user();

        if (! $user || $user->id !== $userPackage->user_id) {
            abort(403);
        }

        $package = $userPackage->package;
        $startsAt = now();
        $endsAt = $startsAt->copy()->addDays($package->duration_days ?? 30);

        \App\Models\UserPackage::create([
            'user_id' => $user->id,
            'package_id' => $package->id,
            'starts_at' => $startsAt,
            'ends_at' => $endsAt,
            'status' => 'active',
        ]);

        return redirect()->route('my-plans')->with('success', 'Package renewed.');
    }
}
