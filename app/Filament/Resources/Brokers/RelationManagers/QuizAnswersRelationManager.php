<?php

namespace App\Filament\Resources\Brokers\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\QuizQuestion;

class QuizAnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'quizAnswers';

    protected static ?string $recordTitleAttribute = 'text';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('recordId')
                ->label('Select Quiz Answer')
                ->helperText('Choose which quiz answer matches this broker')
                ->options(function ($livewire) {
                    // Get already attached answer IDs
                    $attachedAnswerIds = $livewire->getOwnerRecord()
                        ->quizAnswers()
                        ->pluck('quiz_answers.id')
                        ->toArray();
                    
                    $options = [];
                    $questions = QuizQuestion::with('answers')
                        ->where('is_active', true)
                        ->orderBy('order')
                        ->get();
                    
                    foreach ($questions as $question) {
                        foreach ($question->answers as $answer) {
                            // Only include answers that are not already attached
                            if (!in_array($answer->id, $attachedAnswerIds)) {
                                $options[$answer->id] = '❓ ' . $question->title . ' ➜ ✓ ' . $answer->text;
                            }
                        }
                    }
                    
                    return $options;
                })
                ->searchable()
                ->required()
                ->preload()
                ->columnSpanFull()
                ->hidden(fn ($livewire) => $livewire instanceof EditAction),
            TextInput::make('weight')
                ->label('Weight (1-10)')
                ->helperText('Higher weight = stronger match')
                ->numeric()
                ->default(1)
                ->required()
                ->minValue(1)
                ->maxValue(10),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('question.title')
                    ->label('Question')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('text')
                    ->label('Answer')
                    ->limit(50)
                    ->searchable(),
                TextColumn::make('pivot.weight')
                    ->label('Weight')
                    ->numeric()
                    ->sortable(),
            ])
            ->filters([])
            ->headerActions([
                Action::make('attach')
                    ->label('Attach Answer')
                    ->icon('heroicon-m-paper-clip')
                    ->color('success')
                    ->form([
                        Select::make('quiz_answer_id')
                            ->label('Select Quiz Answer')
                            ->helperText('Choose which quiz answer matches this broker')
                            ->options(function () {
                                // Get already attached answer IDs
                                $attachedAnswerIds = $this->getOwnerRecord()
                                    ->quizAnswers()
                                    ->pluck('quiz_answers.id')
                                    ->toArray();
                                
                                $options = [];
                                $questions = QuizQuestion::with('answers')
                                    ->where('is_active', true)
                                    ->orderBy('order')
                                    ->get();
                                
                                foreach ($questions as $question) {
                                    foreach ($question->answers as $answer) {
                                        // Only include answers that are not already attached
                                        if (!in_array($answer->id, $attachedAnswerIds)) {
                                            $options[$answer->id] = '❓ ' . $question->title . ' ➜ ✓ ' . $answer->text;
                                        }
                                    }
                                }
                                
                                return $options;
                            })
                            ->searchable()
                            ->required()
                            ->preload(),
                        TextInput::make('weight')
                            ->label('Weight (1-10)')
                            ->helperText('Higher weight = stronger match')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->minValue(1)
                            ->maxValue(10),
                    ])
                    ->action(function (array $data) {
                        $this->getOwnerRecord()->quizAnswers()->attach($data['quiz_answer_id'], [
                            'weight' => $data['weight'],
                        ]);
                    })
                    ->successNotificationTitle('Answer attached successfully'),
            ])
            ->actions([
                EditAction::make()
                    ->form([
                        TextInput::make('weight')
                            ->label('Weight (1-10)')
                            ->helperText('Higher weight = stronger match')
                            ->numeric()
                            ->default(fn ($record) => $record->pivot->weight)
                            ->required()
                            ->minValue(1)
                            ->maxValue(10),
                    ])
                    ->fillForm(function ($record) {
                        return [
                            'weight' => $record->pivot->weight,
                        ];
                    })
                    ->using(function ($record, array $data) {
                        $this->getOwnerRecord()->quizAnswers()->updateExistingPivot($record->id, [
                            'weight' => $data['weight'],
                        ]);
                        return $record;
                    }),
                Action::make('detach')
                    ->label('Detach')
                    ->icon('heroicon-m-x-mark')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Detach Quiz Answer')
                    ->modalDescription('Are you sure you want to detach this answer from this broker? The answer will remain in the system.')
                    ->action(function ($record, $livewire) {
                        $livewire->getOwnerRecord()->quizAnswers()->detach($record->id);
                    })
                    ->successNotificationTitle('Answer detached successfully'),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('Detach Selected')
                        ->modalHeading('Detach Quiz Answers')
                        ->modalDescription('Are you sure you want to detach the selected answers?')
                        ->action(function ($records, $livewire) {
                            $livewire->getOwnerRecord()->quizAnswers()->detach($records->pluck('id'));
                        }),
                ]),
            ]);
    }
}



