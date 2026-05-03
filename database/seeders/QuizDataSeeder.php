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
        // === QUIZ QUESTIONS ===
        
        // Q1: Trading Experience Level
        $q1 = QuizQuestion::create([
            'title' => 'What is your trading experience level?',
            'description' => 'Select the option that best describes your forex trading experience',
            'order' => 1,
            'is_active' => true,
        ]);
        $a1_1 = QuizAnswer::create(['quiz_question_id' => $q1->id, 'text' => 'Beginner (< 6 months)', 'order' => 1]);
        $a1_2 = QuizAnswer::create(['quiz_question_id' => $q1->id, 'text' => 'Intermediate (6-24 months)', 'order' => 2]);
        $a1_3 = QuizAnswer::create(['quiz_question_id' => $q1->id, 'text' => 'Advanced (2+ years)', 'order' => 3]);

        // Q2: Trading Style Preference
        $q2 = QuizQuestion::create([
            'title' => 'What is your preferred trading style?',
            'description' => 'Choose the trading style that matches your preferences',
            'order' => 2,
            'is_active' => true,
        ]);
        $a2_1 = QuizAnswer::create(['quiz_question_id' => $q2->id, 'text' => 'Scalping (seconds to minutes)', 'order' => 1]);
        $a2_2 = QuizAnswer::create(['quiz_question_id' => $q2->id, 'text' => 'Day Trading (minutes to hours)', 'order' => 2]);
        $a2_3 = QuizAnswer::create(['quiz_question_id' => $q2->id, 'text' => 'Swing Trading (hours to days)', 'order' => 3]);
        $a2_4 = QuizAnswer::create(['quiz_question_id' => $q2->id, 'text' => 'Position Trading (days to weeks)', 'order' => 4]);

        // Q3: Preferred Platform
        $q3 = QuizQuestion::create([
            'title' => 'What trading platform do you prefer?',
            'description' => 'Select your preferred trading platform',
            'order' => 3,
            'is_active' => true,
        ]);
        $a3_1 = QuizAnswer::create(['quiz_question_id' => $q3->id, 'text' => 'MetaTrader 4 (MT4/MT5)', 'order' => 1]);
        $a3_2 = QuizAnswer::create(['quiz_question_id' => $q3->id, 'text' => 'MetaTrader 5 (MT5)', 'order' => 2]);
        $a3_3 = QuizAnswer::create(['quiz_question_id' => $q3->id, 'text' => 'cTrader', 'order' => 3]);
        $a3_4 = QuizAnswer::create(['quiz_question_id' => $q3->id, 'text' => 'WebTrader / Mobile App', 'order' => 4]);

        // Q4: Account Size
        $q4 = QuizQuestion::create([
            'title' => 'What is your intended investment size?',
            'description' => 'This helps us recommend brokers with suitable minimum deposits',
            'order' => 4,
            'is_active' => true,
        ]);
        $a4_1 = QuizAnswer::create(['quiz_question_id' => $q4->id, 'text' => 'Small ($50-$500)', 'order' => 1]);
        $a4_2 = QuizAnswer::create(['quiz_question_id' => $q4->id, 'text' => 'Medium ($500-$5,000)', 'order' => 2]);
        $a4_3 = QuizAnswer::create(['quiz_question_id' => $q4->id, 'text' => 'Large ($5,000+)', 'order' => 3]);

        // Q5: Regulation Priority
        $q5 = QuizQuestion::create([
            'title' => 'How important is broker regulation to you?',
            'description' => 'Select based on your regulatory preferences',
            'order' => 5,
            'is_active' => true,
        ]);
        $a5_1 = QuizAnswer::create(['quiz_question_id' => $q5->id, 'text' => 'Very Important (Tier 1 regulators)', 'order' => 1]);
        $a5_2 = QuizAnswer::create(['quiz_question_id' => $q5->id, 'text' => 'Important (Established regulators)', 'order' => 2]);
        $a5_3 = QuizAnswer::create(['quiz_question_id' => $q5->id, 'text' => 'Moderate concern', 'order' => 3]);

        // Q6: Additional Assets Interest
        $q6 = QuizQuestion::create([
            'title' => 'Are you interested in trading beyond forex?',
            'description' => 'Select if you want to trade other asset classes',
            'order' => 6,
            'is_active' => true,
        ]);
        $a6_1 = QuizAnswer::create(['quiz_question_id' => $q6->id, 'text' => 'Forex only', 'order' => 1]);
        $a6_2 = QuizAnswer::create(['quiz_question_id' => $q6->id, 'text' => 'Forex + CFDs', 'order' => 2]);
        $a6_3 = QuizAnswer::create(['quiz_question_id' => $q6->id, 'text' => 'Forex + Crypto', 'order' => 3]);
        $a6_4 = QuizAnswer::create(['quiz_question_id' => $q6->id, 'text' => 'Multiple assets (Forex, Stocks, Crypto, Commodities)', 'order' => 4]);

        // === PREMIUM BROKERS ===
        
        // Broker 1: FxPro
        $b1 = Broker::create([
            'name' => 'FxPro',
            'description' => 'Premium forex broker with advanced trading tools and professional support',
            'website' => 'https://www.fxpro.com',
            'logo' => 'brokers/fxpro.png',
            'min_deposit' => '$100',
            'regulation' => 'FCA, CySEC, DFSA',
            'years_in_business' => 15,
            'features' => ['MetaTrader 4', 'MetaTrader 5', 'cTrader', 'WebTrader', 'Mobile App'],
            'pros' => ['Low spreads', 'Multiple platforms', 'Excellent customer support', 'Tier-1 regulation', 'Copy trading'],
            'cons' => ['Minimum deposit $100', 'Limited crypto trading'],
            'rating' => 4.8,
            'is_active' => true,
        ]);

        // Broker 2: IC Markets
        $b2 = Broker::create([
            'name' => 'IC Markets',
            'description' => 'Competitive broker offering ultra-tight spreads and high leverage for professional traders',
            'website' => 'https://www.icmarkets.com',
            'logo' => 'brokers/ic-markets.png',
            'min_deposit' => '$200',
            'regulation' => 'ASIC, CySEC',
            'years_in_business' => 12,
            'features' => ['MetaTrader 4', 'MetaTrader 5', 'cTrader', 'Crypto Trading'],
            'pros' => ['Ultra-low spreads', 'High leverage', 'Multiple assets', 'Scalping-friendly'],
            'cons' => ['Higher minimum deposit', 'Limited regulation (no FCA)'],
            'rating' => 4.6,
            'is_active' => true,
        ]);

        // Broker 3: eToro
        $b3 = Broker::create([
            'name' => 'eToro',
            'description' => 'Social trading platform ideal for beginners with copy trading and fractional shares',
            'website' => 'https://www.etoro.com',
            'logo' => 'brokers/etoro.png',
            'min_deposit' => '$50',
            'regulation' => 'FCA, CySEC, ASIC',
            'years_in_business' => 18,
            'features' => ['Social Trading', 'Copy Trading', 'Crypto', 'Stocks', 'ETFs', 'Commodities'],
            'pros' => ['Lowest minimum deposit', 'Copy trading feature', 'Very user-friendly', 'Huge social community'],
            'cons' => ['Higher spreads', 'Proprietary platform only'],
            'rating' => 4.4,
            'is_active' => true,
        ]);

        // Broker 4: Pepperstone
        $b4 = Broker::create([
            'name' => 'Pepperstone',
            'description' => 'Fast-executing broker with tight spreads and advanced technology',
            'website' => 'https://www.pepperstone.com',
            'logo' => 'brokers/pepperstone.png',
            'min_deposit' => '$200',
            'regulation' => 'ASIC, FCA, CySEC',
            'years_in_business' => 11,
            'features' => ['MetaTrader 4', 'MetaTrader 5', 'cTrader', 'TradingView'],
            'pros' => ['Lightning-fast execution', 'Low spreads', 'Multiple platforms', 'Good for scalpers'],
            'cons' => ['Minimum deposit $200', 'Mixed regulation'],
            'rating' => 4.7,
            'is_active' => true,
        ]);

        // Broker 5: XM (XMTrading)
        $b5 = Broker::create([
            'name' => 'XM Global',
            'description' => 'Trusted broker with generous bonuses and excellent customer support',
            'website' => 'https://www.xmglobal.com',
            'logo' => 'brokers/xm.png',
            'min_deposit' => '$5',
            'regulation' => 'ASIC, CySEC, FSA',
            'years_in_business' => 13,
            'features' => ['MetaTrader 4', 'MetaTrader 5', 'WebTrader', 'Mobile App'],
            'pros' => ['Ultra-low minimum ($5)', 'Generous bonuses', 'Multilingual support', 'Educational resources'],
            'cons' => ['Bonus-heavy strategy', 'ASIC restrictions for Australians'],
            'rating' => 4.3,
            'is_active' => true,
        ]);

        // Broker 6: Interactive Brokers
        $b6 = Broker::create([
            'name' => 'Interactive Brokers',
            'description' => 'Professional broker with access to multiple asset classes and lowest commissions',
            'website' => 'https://www.interactivebrokers.com',
            'logo' => 'brokers/interactive-brokers.png',
            'min_deposit' => '$2000',
            'regulation' => 'SEC, FCA, IIROC',
            'years_in_business' => 35,
            'features' => ['TWS Platform', 'WebTrader', 'Multiple markets', 'Stocks, Forex, Futures, Bonds'],
            'pros' => ['Lowest commissions', 'Access to global markets', 'Tier-1 regulation', 'Professional tools'],
            'cons' => ['Steep learning curve', 'High minimum deposit', 'Forex not primary focus'],
            'rating' => 4.9,
            'is_active' => true,
        ]);

        // Broker 7: OANDA
        $b7 = Broker::create([
            'name' => 'OANDA',
            'description' => 'Pioneering forex broker with excellent transparency and educational resources',
            'website' => 'https://www.oanda.com',
            'logo' => 'brokers/oanda.png',
            'min_deposit' => '$1',
            'regulation' => 'CFTC, FCA, IIROC, OSFI',
            'years_in_business' => 27,
            'features' => ['MetaTrader 4', 'OANDA Trade', 'WebTrader', 'Mobile App'],
            'pros' => ['Minimal deposit requirement', 'Tier-1 regulation', 'Transparent pricing', 'Great for beginners'],
            'cons' => ['Higher spreads', 'Limited platforms'],
            'rating' => 4.5,
            'is_active' => true,
        ]);

        // Broker 8: Saxo Bank
        $b8 = Broker::create([
            'name' => 'Saxo Bank',
            'description' => 'Premium investment bank offering full-service trading across all asset classes',
            'website' => 'https://www.saxobank.com',
            'logo' => 'brokers/saxo-bank.png',
            'min_deposit' => '$10000',
            'regulation' => 'Danish FSA, EU regulated',
            'years_in_business' => 28,
            'features' => ['SaxoTraderGO', 'Bloomberg Terminal', 'Multiple Markets', 'Wealth Management'],
            'pros' => ['Premium service', 'Access to all markets', 'Professional tools', 'Excellent research'],
            'cons' => ['Very high minimum', 'Premium pricing', 'For professional traders only'],
            'rating' => 4.9,
            'is_active' => true,
        ]);

        // === BROKER MATCHES (Quiz Answer to Broker Mapping) ===
        
        // Beginners (low deposit, social features, education)
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => $a1_1->id, 'weight' => 5]); // eToro
        BrokerMatch::create(['broker_id' => $b5->id, 'quiz_answer_id' => $a1_1->id, 'weight' => 4]); // XM
        BrokerMatch::create(['broker_id' => $b7->id, 'quiz_answer_id' => $a1_1->id, 'weight' => 4]); // OANDA
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a1_1->id, 'weight' => 2]); // FxPro
        
        // Intermediate traders
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a1_2->id, 'weight' => 4]); // FxPro
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a1_2->id, 'weight' => 4]); // IC Markets
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a1_2->id, 'weight' => 4]); // Pepperstone
        BrokerMatch::create(['broker_id' => $b5->id, 'quiz_answer_id' => $a1_2->id, 'weight' => 3]); // XM
        
        // Advanced traders
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a1_3->id, 'weight' => 5]); // IC Markets
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a1_3->id, 'weight' => 5]); // Pepperstone
        BrokerMatch::create(['broker_id' => $b6->id, 'quiz_answer_id' => $a1_3->id, 'weight' => 4]); // Interactive Brokers
        BrokerMatch::create(['broker_id' => $b8->id, 'quiz_answer_id' => $a1_3->id, 'weight' => 4]); // Saxo Bank
        
        // Scalpers (need tight spreads and fast execution)
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a2_1->id, 'weight' => 5]); // IC Markets
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a2_1->id, 'weight' => 5]); // Pepperstone
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a2_1->id, 'weight' => 3]); // FxPro
        
        // Day traders
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a2_2->id, 'weight' => 4]); // FxPro
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a2_2->id, 'weight' => 4]); // Pepperstone
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a2_2->id, 'weight' => 3]); // IC Markets
        
        // Swing traders
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a2_3->id, 'weight' => 3]); // FxPro
        BrokerMatch::create(['broker_id' => $b7->id, 'quiz_answer_id' => $a2_3->id, 'weight' => 3]); // OANDA
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => $a2_3->id, 'weight' => 3]); // eToro
        
        // Position traders (long-term)
        BrokerMatch::create(['broker_id' => $b7->id, 'quiz_answer_id' => $a2_4->id, 'weight' => 4]); // OANDA
        BrokerMatch::create(['broker_id' => $b6->id, 'quiz_answer_id' => $a2_4->id, 'weight' => 4]); // Interactive Brokers
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a2_4->id, 'weight' => 3]); // FxPro
        
        // MT4/MT5 users
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a3_1->id, 'weight' => 3]); // FxPro
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a3_1->id, 'weight' => 3]); // IC Markets
        BrokerMatch::create(['broker_id' => $b5->id, 'quiz_answer_id' => $a3_1->id, 'weight' => 3]); // XM
        
        // MT5 users
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a3_2->id, 'weight' => 4]); // FxPro
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a3_2->id, 'weight' => 4]); // IC Markets
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a3_2->id, 'weight' => 4]); // Pepperstone
        
        // cTrader users
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a3_3->id, 'weight' => 5]); // IC Markets
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a3_3->id, 'weight' => 4]); // Pepperstone
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a3_3->id, 'weight' => 3]); // FxPro
        
        // Web/Mobile traders
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => $a3_4->id, 'weight' => 5]); // eToro
        BrokerMatch::create(['broker_id' => $b5->id, 'quiz_answer_id' => $a3_4->id, 'weight' => 4]); // XM
        BrokerMatch::create(['broker_id' => $b7->id, 'quiz_answer_id' => $a3_4->id, 'weight' => 4]); // OANDA
        
        // Small account ($50-$500)
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => $a4_1->id, 'weight' => 5]); // eToro
        BrokerMatch::create(['broker_id' => $b5->id, 'quiz_answer_id' => $a4_1->id, 'weight' => 5]); // XM
        BrokerMatch::create(['broker_id' => $b7->id, 'quiz_answer_id' => $a4_1->id, 'weight' => 4]); // OANDA
        
        // Medium account ($500-$5000)
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a4_2->id, 'weight' => 4]); // FxPro
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a4_2->id, 'weight' => 4]); // IC Markets
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a4_2->id, 'weight' => 4]); // Pepperstone
        
        // Large account ($5000+)
        BrokerMatch::create(['broker_id' => $b6->id, 'quiz_answer_id' => $a4_3->id, 'weight' => 5]); // Interactive Brokers
        BrokerMatch::create(['broker_id' => $b8->id, 'quiz_answer_id' => $a4_3->id, 'weight' => 5]); // Saxo Bank
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a4_3->id, 'weight' => 3]); // FxPro
        
        // Tier-1 regulation priority
        BrokerMatch::create(['broker_id' => $b6->id, 'quiz_answer_id' => $a5_1->id, 'weight' => 5]); // Interactive Brokers
        BrokerMatch::create(['broker_id' => $b8->id, 'quiz_answer_id' => $a5_1->id, 'weight' => 5]); // Saxo Bank
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a5_1->id, 'weight' => 5]); // FxPro
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => $a5_1->id, 'weight' => 4]); // eToro
        
        // Established regulation
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a5_2->id, 'weight' => 4]); // IC Markets
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a5_2->id, 'weight' => 4]); // Pepperstone
        BrokerMatch::create(['broker_id' => $b7->id, 'quiz_answer_id' => $a5_2->id, 'weight' => 4]); // OANDA
        
        // Moderate regulation concern
        BrokerMatch::create(['broker_id' => $b5->id, 'quiz_answer_id' => $a5_3->id, 'weight' => 3]); // XM
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a5_3->id, 'weight' => 3]); // IC Markets
        
        // Forex only
        BrokerMatch::create(['broker_id' => $b7->id, 'quiz_answer_id' => $a6_1->id, 'weight' => 4]); // OANDA
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a6_1->id, 'weight' => 3]); // FxPro
        
        // Forex + CFDs
        BrokerMatch::create(['broker_id' => $b1->id, 'quiz_answer_id' => $a6_2->id, 'weight' => 4]); // FxPro
        BrokerMatch::create(['broker_id' => $b4->id, 'quiz_answer_id' => $a6_2->id, 'weight' => 4]); // Pepperstone
        
        // Forex + Crypto
        BrokerMatch::create(['broker_id' => $b2->id, 'quiz_answer_id' => $a6_3->id, 'weight' => 4]); // IC Markets
        BrokerMatch::create(['broker_id' => $b5->id, 'quiz_answer_id' => $a6_3->id, 'weight' => 4]); // XM
        
        // Multiple assets
        BrokerMatch::create(['broker_id' => $b6->id, 'quiz_answer_id' => $a6_4->id, 'weight' => 5]); // Interactive Brokers
        BrokerMatch::create(['broker_id' => $b8->id, 'quiz_answer_id' => $a6_4->id, 'weight' => 5]); // Saxo Bank
        BrokerMatch::create(['broker_id' => $b3->id, 'quiz_answer_id' => $a6_4->id, 'weight' => 4]); // eToro
    }
}
