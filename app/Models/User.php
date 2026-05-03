<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'pending_email',
        'status',
        'avatar',
        'phone',
        'country_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    public function userPackages()
    {
        return $this->hasMany(UserPackage::class);
    }

    public function latestUserPackage()
    {
        return $this->hasOne(UserPackage::class)->latestOfMany();
    }

    public function affiliate()
    {
        return $this->hasOne(Affiliate::class);
    }

    public function referredByAffiliate()
    {
        return $this->hasMany(AffiliateReferral::class, 'referred_user_id');
    }
}
