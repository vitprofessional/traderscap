<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QuizAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'quiz_question_id',
        'text',
        'description',
        'order',
    ];

    public function question()
    {
        return $this->belongsTo(QuizQuestion::class, 'quiz_question_id');
    }

    public function matches()
    {
        return $this->hasMany(BrokerMatch::class);
    }

    public function brokers()
    {
        return $this->belongsToMany(Broker::class, 'broker_matches')
            ->withPivot('weight')
            ->withTimestamps();
    }
}
