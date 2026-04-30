<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListCountries extends ListRecords
{
    protected static string $resource = CountryResource::class;

    protected ?string $subheading = 'Manage the list of supported countries and their ISO and international phone codes.';

    public function getTitle(): string|Htmlable
    {
        return 'Countries';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add country')
                ->icon('heroicon-m-plus'),
        ];
    }
}
