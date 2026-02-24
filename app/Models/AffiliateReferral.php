<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AffiliateReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliate_id',
        'referred_user_id',
        'referral_code',
        'purchase_amount',
        'commission_earned',
        'status',
        'purchased_at',
    ];

    protected $casts = [
        'purchase_amount' => 'decimal:2',
        'commission_earned' => 'decimal:2',
        'purchased_at' => 'datetime',
    ];

    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    public function referredUser()
    {
        return $this->belongsTo(User::class, 'referred_user_id');
    }

    public function commission()
    {
        return $this->hasOne(AffiliateCommission::class);
    }
}
