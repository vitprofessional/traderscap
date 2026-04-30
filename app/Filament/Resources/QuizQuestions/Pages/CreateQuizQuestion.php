<?php

namespace App\Filament\Resources\QuizQuestions\Pages;

use App\Filament\Resources\QuizQuestions\QuizQuestionResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;

class CreateQuizQuestion extends CreateRecord
{
    protected static string $resource = QuizQuestionResource::class;

    protected ?string $subheading = 'Create a clear question, set its order, and publish it when it is ready for the quiz.';

    public function getTitle(): string|Htmlable
    {
        return 'Create Quiz Question';
    }

    public function getMaxContentWidth(): Width|string|null
    {
        return Width::SevenExtraLarge;
    }
}
