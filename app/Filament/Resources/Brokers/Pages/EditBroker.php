<?php

namespace App\Filament\Resources\Brokers\Pages;

use App\Filament\Resources\Brokers\BrokerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditBroker extends EditRecord
{
    protected static string $resource = BrokerResource::class;

    protected ?string $subheading = 'Update broker information, trading details, features, and quiz answer associations.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Broker';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete broker')
                ->requiresConfirmation(),
        ];
    }
}
