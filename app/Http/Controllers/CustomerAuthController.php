<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput();
    }

    public function customerLogout(Request $request)
    {
        // Laravel logout
        Auth::logout();

        // Session destroy
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect to WordPress login page
        $wordpressUrl = rtrim(config('services.sso.wordpress_url'), '/');

        return redirect($wordpressUrl . '/customer-login/');
    }
}
