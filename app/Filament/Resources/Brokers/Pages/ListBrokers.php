<?php

namespace App\Filament\Resources\Brokers\Pages;

use App\Filament\Resources\Brokers\BrokerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListBrokers extends ListRecords
{
    protected static string $resource = BrokerResource::class;

    protected ?string $subheading = 'Manage the broker catalog used in the broker-matching quiz and public recommendations.';

    public function getTitle(): string|Htmlable
    {
        return 'Brokers';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add broker')
                ->icon('heroicon-m-plus'),
        ];
    }
}
