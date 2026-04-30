<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreateTicket extends CreateRecord
{
    protected static string $resource = TicketResource::class;

    protected ?string $subheading = 'Create a new support ticket on behalf of a customer.';

    public function getTitle(): string|Htmlable
    {
        return 'Open Ticket';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }
}
