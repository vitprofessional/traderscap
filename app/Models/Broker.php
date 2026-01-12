<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Broker extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'website',
        'logo',
        'min_deposit',
        'regulation',
        'years_in_business',
        'features',
        'pros',
        'cons',
        'rating',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'pros' => 'array',
        'cons' => 'array',
        'rating' => 'float',
        'is_active' => 'boolean',
    ];

    public function matches()
    {
        return $this->hasMany(BrokerMatch::class);
    }

    public function quizAnswers()
    {
        return $this->belongsToMany(QuizAnswer::class, 'broker_matches')
            ->withPivot('weight')
            ->withTimestamps();
    }
}
