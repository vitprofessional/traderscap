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
        'account_status',
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

    protected static function booted(): void
    {
        static::updated(function (self $user): void {
            if (! $user->wasChanged('account_status')) {
                return;
            }

            if (in_array($user->account_status, ['registered', 'banned'], true)) {
                $latestPackage = $user->userPackages()->latest('id')->first();

                if ($latestPackage) {
                    $latestPackage->delete();
                }

                $user->syncStatus();
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class);
    }

    public function userPackages()
    {
        return $this->hasMany(UserPackage::class);
    }

        public function getEffectiveStatusAttribute(): string
        {
            $statuses = $this->relationLoaded('userPackages')
                ? $this->userPackages->pluck('status')
                : $this->userPackages()
                    ->whereIn('status', ['registered', 'pending', 'active_waiting', 'active', 'expired'])
                    ->pluck('status');

            return $this->deriveStatusFromPackageStatuses($statuses->all());
        }

    /**
     * Derive the correct status from user_packages and persist it.
     *
     * Priority:  active/active_waiting → 'active'
     *            pending/registered    → 'pending'
     *            only expired          → 'expired'
     *            no packages at all    → 'registered'
     */
    public function syncStatus(): void
    {
        $derived = $this->effective_status;

        if ($this->status !== $derived) {
            $this->status = $derived;
            $this->saveQuietly();
        }
    }

    /**
     * @param  array<int, string>  $statuses
     */
    private function deriveStatusFromPackageStatuses(array $statuses): string
    {
        $statuses = collect($statuses);

        if ($statuses->intersect(['active', 'active_waiting'])->isNotEmpty()) {
            return 'active';
        }

        if ($statuses->intersect(['pending', 'registered'])->isNotEmpty()) {
            return 'pending';
        }

        if ($statuses->contains('expired')) {
            return 'expired';
        }

        return 'registered';
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
