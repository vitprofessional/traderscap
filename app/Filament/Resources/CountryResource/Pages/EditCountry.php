<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditCountry extends EditRecord
{
    protected static string $resource = CountryResource::class;

    protected ?string $subheading = 'Update this country\'s name, ISO codes, phone prefix, or active status.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Country';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete country')
                ->requiresConfirmation(),
        ];
    }
}
