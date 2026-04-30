<?php

namespace App\Filament\Resources\QuizQuestions\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class QuizQuestionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Question content')
                    ->description('Write the question exactly as the quiz visitor will see it.')
                    ->icon('heroicon-o-document-text')
                    ->schema([
                        TextInput::make('title')
                            ->label('Question title')
                            ->placeholder('What is your trading experience level?')
                            ->helperText('Keep the title short, specific, and easy to scan.')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Question guidance')
                            ->placeholder('Help the user understand what this question is asking.')
                            ->helperText('Optional. Shown directly below the title in the quiz flow.')
                            ->rows(6)
                            ->default(null)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Publishing')
                    ->description('Control when the question appears and how it is ordered.')
                    ->icon('heroicon-o-rocket-launch')
                    ->schema([
                        TextInput::make('order')
                            ->label('Display order')
                            ->helperText('Lower numbers appear earlier in the quiz.')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Publish question')
                            ->helperText('Turn this off while the question is still being drafted.')
                            ->default(true)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }
}
