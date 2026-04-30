<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListAdmins extends ListRecords
{
    protected static string $resource = AdminResource::class;

    protected ?string $subheading = 'Manage administrator accounts and their role-based access to this panel.';

    public function getTitle(): string|Htmlable
    {
        return 'Administrators';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New administrator')
                ->icon('heroicon-m-plus'),
        ];
    }
}
