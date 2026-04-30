<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditTestimonial extends EditRecord
{
    protected static string $resource = TestimonialResource::class;

    protected ?string $subheading = 'Update the testimonial content, author details, or display order.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Testimonial';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete testimonial')
                ->requiresConfirmation(),
        ];
    }
}
