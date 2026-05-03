<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPackage extends Model
{
    use HasFactory;

    protected $table = 'user_packages';

    /**
     * Automatically sync the parent user's status whenever a package
     * record is created, updated, or deleted.
     */
    protected static function boot(): void
    {
        parent::boot();

        $sync = function (self $up): void {
            optional($up->user)->syncStatus();
        };

        static::saved($sync);
        static::deleted($sync);
    }

    protected $fillable = [
        'user_id',
        'package_id',
        'broker_name',
        'trading_id',
        'trading_password',
        'trading_server',
        'equity',
        'starts_at',
        'ends_at',
        'status',
    ];

    protected $casts = [
        'equity' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}
