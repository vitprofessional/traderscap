<?php

namespace App\Filament\Resources\QuizQuestions\Pages;

use App\Filament\Resources\QuizQuestions\QuizQuestionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class ListQuizQuestions extends ListRecords
{
    protected static string $resource = QuizQuestionResource::class;

    protected ?string $subheading = 'Manage the questions shown in the broker-matching quiz. Drag rows to reorder or toggle Published to control visibility.';

    public function getTitle(): string|Htmlable
    {
        return 'Quiz Questions';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('New question')
                ->icon('heroicon-m-plus'),
        ];
    }
}
