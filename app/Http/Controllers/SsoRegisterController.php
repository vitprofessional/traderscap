<?php

namespace App\Http\Controllers;

use App\Models\SsoLoginToken;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class SsoRegisterController extends Controller
{
    public function registerRequest(Request $request): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $rateKey = 'sso-register:' . $request->ip() . ':' . md5($data['email']);

        if (RateLimiter::tooManyAttempts($rateKey, 5)) {
            return response()->json([
                'success' => false,
                'message' => 'Too many registration attempts. Please try again later.',
                'errors' => [
                    'email' => ['Too many registration attempts. Please try again later.'],
                ],
            ], 429);
        }

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        RateLimiter::clear($rateKey);

        $plainToken = Str::random(64);

        $tokenRow = SsoLoginToken::create([
            'user_id' => $user->id,
            'token' => hash('sha256', $plainToken),
            'expires_at' => now()->addMinutes(2),
            'source' => 'wordpress-register',
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
            'message' => 'Registration successful.',
            'redirect_url' => $redirectUrl,
        ]);
    }
}