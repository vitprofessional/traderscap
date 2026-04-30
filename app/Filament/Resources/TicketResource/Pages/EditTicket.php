<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditTicket extends EditRecord
{
    protected static string $resource = TicketResource::class;

    protected ?string $subheading = 'Update the ticket subject, description, or status. Use the Messages panel below to add a reply.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Ticket';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete ticket')
                ->requiresConfirmation(),
        ];
    }
}
