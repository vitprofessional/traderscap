<?php

namespace App\Filament\Resources\AffiliateResource\Pages;

use App\Filament\Resources\AffiliateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditAffiliate extends EditRecord
{
    protected static string $resource = AffiliateResource::class;

    protected ?string $subheading = 'Update this affiliate\'s commission rate or change their approval status.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Affiliate';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Remove affiliate')
                ->requiresConfirmation(),
        ];
    }
}
