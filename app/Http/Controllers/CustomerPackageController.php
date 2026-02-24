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

        $userPackage = $user
            ? $user->userPackages()
                ->with('package')
                ->whereIn('status', ['pending', 'active_waiting', 'active', 'expired'])
                ->latest()
                ->first()
            : null;

        return view('customer.my-plans', [
            'userPackage' => $userPackage,
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

        $userPackage->update([
            'package_id' => $package?->id,
            'starts_at' => null,
            'ends_at' => null,
            'status' => 'pending',
        ]);

        return redirect()->route('my-plans')->with('success', 'Renewal request submitted and pending admin verification.');
    }
}
