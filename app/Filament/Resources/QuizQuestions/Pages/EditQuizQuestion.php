<?php

namespace App\Filament\Resources\QuizQuestions\Pages;

use App\Filament\Resources\QuizQuestions\QuizQuestionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class EditQuizQuestion extends EditRecord
{
    protected static string $resource = QuizQuestionResource::class;

    protected ?string $subheading = 'Update the question, its guidance text, display order, or published status. Manage its answer choices in the Answers panel below.';

    public function getTitle(): string|Htmlable
    {
        return 'Edit Quiz Question';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make()
                ->label('Delete question')
                ->requiresConfirmation(),
        ];
    }
}
