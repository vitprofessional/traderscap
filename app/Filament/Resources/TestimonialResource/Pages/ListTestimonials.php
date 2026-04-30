<?php

namespace App\Filament\Resources\TestimonialResource\Pages;

use App\Filament\Resources\TestimonialResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListTestimonials extends ListRecords
{
    protected static string $resource = TestimonialResource::class;

    protected ?string $subheading = 'Manage customer testimonials displayed on the public website. Control their display order and visibility.';

    public function getTitle(): string|Htmlable
    {
        return 'Testimonials';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Add testimonial')
                ->icon('heroicon-m-plus'),
        ];
    }
}
