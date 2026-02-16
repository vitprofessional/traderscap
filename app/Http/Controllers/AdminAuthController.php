<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log;
use App\Models\Admin;

class AdminAuthController
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $guard = Auth::guard('admin');

        $attempt = $guard->attempt(['email' => $data['email'], 'password' => $data['password']], $request->boolean('remember'));

        if ($attempt) {
            $admin = $guard->user();

            if (! $admin->is_active) {
                $guard->logout();
                Log::warning('Admin login attempt for disabled account', ['email' => $data['email']]);
                return Redirect::back()->withErrors(['email' => 'Account is disabled.']);
            }

            Log::info('Admin logged in', ['email' => $data['email'], 'id' => $admin->id]);

            $request->session()->regenerate();

            return redirect()->intended(config('filament.home_url', '/admin'));
        }

        // Minimal logging on failed attempts
        Log::warning('Admin login failed', ['email' => $data['email']]);

        return Redirect::back()->withErrors(['email' => 'Invalid credentials.'])->withInput();
    }

    public function logout(Request $request)
    {
        $guard = Auth::guard('admin');
        $guard->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
