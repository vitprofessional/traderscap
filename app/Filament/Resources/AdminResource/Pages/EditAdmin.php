<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditAdmin extends EditRecord
{
    protected static string $resource = AdminResource::class;

    protected ?string $subheading = 'Update this administrator\'s name, email address, password, or access role.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Administrator';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete administrator')
                ->requiresConfirmation(),
        ];
    }
}
