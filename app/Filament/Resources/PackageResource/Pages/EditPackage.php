<?php

namespace App\Filament\Resources\PackageResource\Pages;

use App\Filament\Resources\PackageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditPackage extends EditRecord
{
    protected static string $resource = PackageResource::class;

    protected ?string $subheading = 'Update the package name, pricing, duration, or listed facilities.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Package';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete package')
                ->requiresConfirmation(),
        ];
    }
}
