<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreatePackage extends CreateRecord
{
    protected static string $resource = PackageResource::class;

    protected ?string $subheading = 'Define a new service package with pricing, duration, and included facilities.';

    public function getTitle(): string|Htmlable
    {
        return 'Create Package';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }
}
