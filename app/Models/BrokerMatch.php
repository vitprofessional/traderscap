<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BrokerMatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'broker_id',
        'quiz_answer_id',
        'weight',
    ];

    public function broker()
    {
        return $this->belongsTo(Broker::class);
    }

    public function quizAnswer()
    {
        return $this->belongsTo(QuizAnswer::class);
    }
}
