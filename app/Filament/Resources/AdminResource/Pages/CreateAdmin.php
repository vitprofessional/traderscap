<?php

namespace App\Filament\Resources\AdminResource\Pages;

use App\Filament\Resources\AdminResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreateAdmin extends CreateRecord
{
    protected static string $resource = AdminResource::class;

    protected ?string $subheading = 'Create a new administrator account and assign a role and access level.';

    public function getTitle(): string|Htmlable
    {
        return 'Create Administrator';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }
}
