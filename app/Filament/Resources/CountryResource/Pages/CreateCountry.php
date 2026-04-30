<?php

namespace App\Filament\Resources\CountryResource\Pages;

use App\Filament\Resources\CountryResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreateCountry extends CreateRecord
{
    protected static string $resource = CountryResource::class;

    protected ?string $subheading = 'Register a new country with its ISO codes and international phone prefix.';

    public function getTitle(): string|Htmlable
    {
        return 'Add Country';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }
}
