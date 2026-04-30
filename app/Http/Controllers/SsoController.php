<?php

namespace App\Http\Controllers;

use App\Models\SsoLoginToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SsoController extends Controller
{
    public function loginRequest(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $rateKey = 'sso-login:' . $request->ip() . ':' . md5($data['email']);

        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many login attempts. Please try again later.',
            ], 429);
        }

        $user = User::where('email', $data['email'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            RateLimiter::hit($rateKey, 60);

            return response()->json([
                'success' => false,
                'message' => 'The provided credentials do not match our records.',
            ], 422);
        }

        RateLimiter::clear($rateKey);

        $plainToken = Str::random(64);

        $tokenRow = SsoLoginToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $plainToken),
            'expires_at' => now()->addMinutes(2),
            'source' => 'wordpress',
            'ip_address' => $request->ip(),
            'user_agent' => (string) $request->userAgent(),
        ]);

        $redirectUrl = URL::temporarySignedRoute(
            'sso.consume',
            now()->addMinutes(2),
            [
                'token' => $plainToken,
                'sso' => $tokenRow->id,
            ]
        );

        return response()->json([
            'success' => true,
            'redirect_url' => $redirectUrl,
        ]);
    }

    public function consume(Request $request): RedirectResponse
    {
        if (! $request->hasValidSignature()) {
            abort(403, 'Invalid or tampered login link.');
        }

        $request->validate([
            'token' => ['required', 'string'],
            'sso' => ['required', 'integer'],
        ]);

        $tokenRow = SsoLoginToken::with('user')->findOrFail($request->integer('sso'));

        if ($tokenRow->used_at !== null) {
            abort(403, 'This login link has already been used.');
        }

        if ($tokenRow->expires_at->isPast()) {
            abort(403, 'This login link has expired.');
        }

        if (! hash_equals($tokenRow->token, hash('sha256', (string) $request->string('token')))) {
            abort(403, 'Invalid login token.');
        }

        Auth::login($tokenRow->user, true);
        $request->session()->regenerate();

        $tokenRow->update([
            'used_at' => now(),
        ]);

        return redirect()->intended('/dashboard');
    }
}