<?php

namespace App\Filament\Resources\UserPackageResource\Pages;

use App\Filament\Resources\UserResource;
use App\Filament\Resources\UserPackageResource;
use App\Models\UserPackage;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditUserPackage extends EditRecord
{
    protected static string $resource = UserPackageResource::class;

    public function mount(int | string $record): void
    {
        $userPackage = UserPackage::query()->find($record);

        $this->redirect(
            $userPackage?->user_id
                ? UserResource::getUrl('edit', ['record' => $userPackage->user_id])
                : UserResource::getUrl('index')
        );
    }

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
