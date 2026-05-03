<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class CustomerEmailVerificationController extends Controller
{
    /**
     * Show the email-verification notice page.
     * Redirects straight to the profile if already verified.
     */
    public function notice(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('profile')->with('profile_success', 'Your email address is already verified.');
        }

        return view('customer.verify-email');
    }

    /**
     * Handle the signed verification link from the email.
     */
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return redirect()->route('profile')->with('profile_success', 'Your email address is already verified.');
        }

        $request->fulfill();

        return redirect()->route('profile')->with('profile_success', 'Email address verified successfully!');
    }

    /**
     * Resend the verification email.
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return back()->with('resend_info', 'Your email is already verified.');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('resend_success', 'Verification email sent! Please check your inbox (and spam folder).');
    }
}
