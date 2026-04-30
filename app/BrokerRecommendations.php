<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Broker;

class BrokerRecommendations extends Component
{
    public function render()
    {
        // Get all active brokers ordered by rating
        $brokers = Broker::where('is_active', true)
            ->orderByDesc('rating')
            ->orderByDesc('years_in_business')
            ->get();

        return view('livewire.broker-recommendations', [
            'brokers' => $brokers,
        ]);
    }
}
