<?php

namespace App\Filament\Resources\AffiliateResource\Pages;

use App\Filament\Resources\AffiliateResource;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListAffiliates extends ListRecords
{
    protected static string $resource = AffiliateResource::class;

    protected ?string $subheading = 'Review affiliate applications, manage commission rates, and approve or reject membership.';

    public function getTitle(): string|Htmlable
    {
        return 'Affiliates';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
