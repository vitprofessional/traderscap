<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Affiliate;
use Illuminate\Support\Facades\Auth;

class AffiliateController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $affiliate = $user->affiliate;

        if (!$affiliate) {
            return view('customer.partners.index', [
                'affiliate' => null,
                'isApplicant' => false,
            ]);
        }

        $referrals = $affiliate->referrals()
            ->with('referredUser')
            ->latest()
            ->paginate(15);

        $commissions = $affiliate->commissions()
            ->latest()
            ->paginate(10);

        $stats = [
            'total_referrals' => $affiliate->total_referrals,
            'active_referrals' => $affiliate->referrals()->where('status', 'completed')->count(),
            'pending_referrals' => $affiliate->referrals()->where('status', 'pending')->count(),
            'total_commissions' => $affiliate->total_commissions,
            'pending_commissions' => $affiliate->commissions()->where('status', 'pending')->sum('amount'),
            'paid_commissions' => $affiliate->commissions()->where('status', 'paid')->sum('amount'),
        ];

        return view('customer.partners.dashboard', [
            'affiliate' => $affiliate,
            'referrals' => $referrals,
            'commissions' => $commissions,
            'stats' => $stats,
        ]);
    }

    public function apply()
    {
        $user = Auth::user();

        if ($user->affiliate) {
            return redirect()->route('partners')->with('info', 'You are already an affiliate member.');
        }

        return view('customer.partners.apply');
    }

    public function storeApplication(Request $request)
    {
        $user = Auth::user();

        if ($user->affiliate) {
            return redirect()->route('partners')->with('error', 'You are already an affiliate member.');
        }

        $validated = $request->validate([
            'motivation' => ['required', 'string', 'min:50', 'max:1000'],
            'website_url' => ['nullable', 'url'],
            'agree_terms' => ['required', 'accepted'],
        ]);

        $affiliate = Affiliate::create([
            'user_id' => $user->id,
            'commission_rate' => 10.00,
            'is_active' => false,
        ]);

        // Store application data in session or separate table if needed
        session()->put('affiliate_application', [
            'affiliate_id' => $affiliate->id,
            'motivation' => $validated['motivation'],
            'website_url' => $validated['website_url'],
            'applied_at' => now(),
        ]);

        return redirect()->route('partners')->with('success', 'Your affiliate application has been submitted! We will review it and notify you soon.');
    }

    public function copyReferralCode()
    {
        $user = Auth::user();
        $affiliate = $user->affiliate;

        if (!$affiliate) {
            return response()->json(['error' => 'Not an affiliate'], 403);
        }

        return response()->json([
            'code' => $affiliate->referral_code,
            'message' => 'Referral code copied to clipboard',
        ]);
    }

    public function getReferralLink()
    {
        $user = Auth::user();
        $affiliate = $user->affiliate;

        if (!$affiliate) {
            return response()->json(['error' => 'Not an affiliate'], 403);
        }

        $referralLink = route('register') . '?ref=' . $affiliate->referral_code;

        return response()->json([
            'link' => $referralLink,
            'code' => $affiliate->referral_code,
        ]);
    }
}
