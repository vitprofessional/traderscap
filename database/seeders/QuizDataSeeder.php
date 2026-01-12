<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\QuizQuestion;
use App\Models\QuizAnswer;
use App\Models\Broker;
use App\Models\BrokerMatch;

class QuizDataSeeder extends Seeder
{
    public function run(): void
    {
        // Create quiz questions
        $q1 = QuizQuestion::create([
            'title' => 'What is your trading experience level?',
            'description' => 'Select the option that best describes your forex trading experience',
            'order' => 1,
            'is_active' => true,
        ]);

        QuizAnswer::create(['quiz_question_id' => $q1->id, 'text' => 'Beginner', 'order' => 1]);
        QuizAnswer::create(['quiz_question_id' => $q1->id, 'text' => 'Intermediate', 'order' => 2]);
        QuizAnswer::create(['quiz_question_id' => $q1->id, 'text' => 'Advanced', 'order' => 3]);

        $q2 = QuizQuestion::create([
            'title' => 'What is your preferred trading style?',
            'description' => 'Choose the trading style that matches your preferences',
            'order' => 2,
            'is_active' => true,
        ]);

        QuizAnswer::create(['quiz_question_id' => $q2->id, 'text' => 'Scalping (quick trades)', 'order' => 1]);
        QuizAnswer::create(['quiz_question_id' => $q2->id, 'text' => 'Day Trading', 'order' => 2]);
        QuizAnswer::create(['quiz_question_id' => $q2->id, 'text' => 'Swing Trading', 'order' => 3]);

        // Create some test brokers
        $b1 = Broker::create([
            'name' => 'FxPro',
            'description' => 'Professional forex broker with advanced trading tools',
            'website' => 'https://www.fxpro.com',
            'min_deposit' => 100,
            'regulation' => 'FCA, CySEC, DFSA',
            'years_in_business' => 15,
            'features' => ['MetaTrader 4', 'MetaTrader 5', 'cTrader'],
            'pros' => ['Low spreads', 'Multiple platforms', 'Good customer support'],
            'cons' => ['Higher minimum deposit', 'Limited crypto pairs'],
            'rating' => 4.5,
            'is_active' => true,
        ]);

        $b2 = Broker::create([
            'name' => 'IC Markets',
            'description' => 'Competitive forex broker for all traders',
            'website' => 'https://www.icmarkets.com',
            'min_deposit' => 200,
            'regulation' => 'ASIC, CySEC',
            'years_in_business' => 12,
            'features' => ['MetaTrader 4', 'MetaTrader 5', 'cTrader', 'Crypto'],
            'pros' => ['Very low spreads', 'High leverage', 'Multiple assets'],
            'cons' => ['Australian based', 'Withdrawal fees'],
            'rating' => 4.3,
            'is_active' => true,
        ]);

        $b3 = Broker::create([
            'name' => 'eToro',
            'description' => 'Social trading and copy trading platform',
            'website' => 'https://www.etoro.com',
            'min_deposit' => 50,
            'regulation' => 'FCA, CySEC, ASIC',
            'years_in_business' => 18,
            'features' => ['Social Trading', 'Copy Trading', 'Crypto', 'Stocks'],
            'pros' => ['Low minimum deposit', 'Copy trading feature', 'User friendly'],
            'cons' => ['Higher spreads', 'Limited to proprietary platform'],
            'rating' => 4.0,
            'is_active' => true,
        ]);

        // Create broker matches (which answers match which brokers)
        // For beginner traders
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => 1, 'weight' => 3]); // eToro for beginners
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => 1, 'weight' => 1]);
        
        // For intermediate traders
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => 2, 'weight' => 2]);
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => 2, 'weight' => 2]);
        
        // For advanced traders
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => 3, 'weight' => 3]);
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => 3, 'weight' => 2]);

        // For scalpers
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => 4, 'weight' => 3]);
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => 4, 'weight' => 2]);

        // For day traders
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => 5, 'weight' => 2]);
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => 5, 'weight' => 2]);

        // For swing traders
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => 6, 'weight' => 2]);
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => 6, 'weight' => 1]);
    }
}
