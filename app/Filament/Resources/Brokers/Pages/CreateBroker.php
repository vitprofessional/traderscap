<?php

namespace App\Filament\Resources\Brokers\Pages;

use App\Filament\Resources\Brokers\BrokerResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreateBroker extends CreateRecord
{
    protected static string $resource = BrokerResource::class;

    protected ?string $subheading = 'Register a new broker with their identity, trading details, features, and quiz answer associations.';

    public function getTitle(): string|Htmlable
    {
        return 'Add Broker';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }
}
