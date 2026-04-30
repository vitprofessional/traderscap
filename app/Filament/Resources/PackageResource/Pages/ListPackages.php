<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListPackages extends ListRecords
{
    protected static string $resource = PackageResource::class;

    protected ?string $subheading = 'Manage the service packages available for customers to subscribe to.';

    public function getTitle(): string|Htmlable
    {
        return 'Packages';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New package')
                ->icon('heroicon-m-plus'),
        ];
    }
}
