<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomerDashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $userPackages = $user ? $user->userPackages()->with('package')->orderByDesc('starts_at')->get() : collect();

        return view('customer.dashboard', [
            'user' => $user,
            'userPackages' => $userPackages,
        ]);
    }
}
