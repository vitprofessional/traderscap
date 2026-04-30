<?php

namespace App\Filament\Resources\UserPackageResource\Pages;

use App\Filament\Resources\UserPackageResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditUserPackage extends EditRecord
{
    protected static string $resource = UserPackageResource::class;

    protected ?string $subheading = 'Update subscription details, trading credentials, or status for this user package.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit User Package';
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
