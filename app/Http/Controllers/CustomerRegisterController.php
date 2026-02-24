<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Affiliate;
use App\Models\AffiliateReferral;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class CustomerRegisterController extends Controller
{
    public function showRegistrationForm(Request $request)
    {
        $referralCode = $request->query('ref');
        return view('auth.register', ['referralCode' => $referralCode]);
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Handle affiliate referral if referral code is provided
        $referralCode = $request->input('referral_code');
        if ($referralCode) {
            $affiliate = Affiliate::where('referral_code', $referralCode)
                ->where('is_active', true)
                ->first();

            if ($affiliate) {
                AffiliateReferral::create([
                    'affiliate_id' => $affiliate->id,
                    'referred_user_id' => $user->id,
                    'referral_code' => $referralCode,
                    'status' => 'pending',
                ]);
            }
        }

        Auth::login($user);

        return redirect()->intended('/dashboard');
    }
}
