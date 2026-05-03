<?php

namespace App\Filament\Resources\UserPackageResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserPackageResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreateUserPackage extends CreateRecord
{
    protected static string $resource = UserPackageResource::class;

    public function mount(): void
    {
        $this->redirect(UserResource::getUrl('index'));
    }

    protected ?string $subheading = 'Attach a package to a customer account and configure their trading credentials.';

    public function getTitle(): string|Htmlable
    {
        return 'Assign Package';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }
}
