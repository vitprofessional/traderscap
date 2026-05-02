<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Broker;
use App\Models\Package;

class CustomerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $userPackages = $user ? $user->userPackages()->with('package')->orderByDesc('starts_at')->get() : collect();

        $topBrokers = Broker::where('is_active', true)->orderByDesc('rating')->limit(4)->get();

        $packages = class_exists(\App\Models\Package::class)
            ? \App\Models\Package::where('is_active', true)->orderBy('price')->limit(3)->get()
            : collect();

        return view('customer.dashboard', [
            'user'         => $user,
            'userPackages' => $userPackages,
            'topBrokers'   => $topBrokers,
            'packages'     => $packages,
        ]);
    }
}
