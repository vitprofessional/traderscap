<?php

namespace App\Filament\Resources\UserPackageResource\Pages;

use App\Filament\Resources\UserPackageResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListUserPackages extends ListRecords
{
    protected static string $resource = UserPackageResource::class;

    protected ?string $subheading = 'Track all active and past package subscriptions across your customer base.';

    public function getTitle(): string|Htmlable
    {
        return 'User Packages';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Assign package')
                ->icon('heroicon-m-plus'),
        ];
    }
}
