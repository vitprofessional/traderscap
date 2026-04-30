<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class SsoPasswordController extends Controller
{
    public function forgotPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink([
            'email' => $data['email'],
        ]);

        if ($status !== Password::RESET_LINK_SENT) {
            return response()->json([
                'success' => false,
                'message' => __($status),
                'errors' => [
                    'email' => [__($status)],
                ],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => __($status),
        ]);
    }
    

    public function showResetPage(Request $request, string $token)
    {
        $email = $request->query('email', '');

        return redirect(
            rtrim(config('services.sso.wordpress_url'), '/') .
            '/customer-reset-password/?token=' . urlencode($token) .
            '&email=' . urlencode($email)
        );
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $data = $request->validate([
            'token' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $status = Password::reset(
            [
                'email' => $data['email'],
                'password' => $data['password'],
                'password_confirmation' => $data['password_confirmation'],
                'token' => $data['token'],
            ],
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status !== Password::PASSWORD_RESET) {
            return response()->json([
                'success' => false,
                'message' => __($status),
                'errors' => [
                    'email' => [__($status)],
                ],
            ], 422);
        }

        return response()->json([
            'success' => true,
            'message' => __($status),
        ]);
    }
}