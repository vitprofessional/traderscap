<?php

namespace App\Filament\Resources\TicketResource\Pages;

use App\Filament\Resources\TicketResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListTickets extends ListRecords
{
    protected static string $resource = TicketResource::class;

    protected ?string $subheading = 'Review and respond to customer support requests. Open tickets are highlighted in the navigation badge.';

    public function getTitle(): string|Htmlable
    {
        return 'Support Tickets';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Open ticket')
                ->icon('heroicon-m-plus'),
        ];
    }
}
