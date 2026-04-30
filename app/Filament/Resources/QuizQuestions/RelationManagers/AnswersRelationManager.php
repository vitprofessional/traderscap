<?php

namespace App\Filament\Resources\QuizQuestions\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Models\QuizAnswer;

class AnswersRelationManager extends RelationManager
{
    protected static string $relationship = 'answers';

    protected static ?string $recordTitleAttribute = 'text';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'md' => 2])
            ->components([
                Section::make('Answer content')
                    ->description('Write the answer exactly as the quiz visitor will see it.')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->schema([
                        TextInput::make('text')
                            ->label('Answer text')
                            ->placeholder('e.g. Beginner (less than 6 months)')
                            ->helperText('Keep this short and immediately understandable.')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Extended description')
                            ->placeholder('Optional detail shown under the answer in the quiz.')
                            ->helperText('Use this to clarify what choosing this answer means.')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'md' => 2]),
                Section::make('Settings')
                    ->description('Set the order in which this answer is listed.')
                    ->icon('heroicon-o-adjustments-horizontal')
                    ->schema([
                        TextInput::make('order')
                            ->label('Display order')
                            ->helperText('Lower numbers appear first.')
                            ->numeric()
                            ->default(0)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'md' => 2]),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->width(48),
                TextColumn::make('text')
                    ->label('Answer')
                    ->searchable()
                    ->description(fn ($record) => $record->description)
                    ->wrap()
                    ->weight('medium'),
                TextColumn::make('created_at')
                    ->label('Added')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->reorderable('order')
            ->filters([])
            ->headerActions([
                CreateAction::make()
                    ->label('Add answer')
                    ->icon('heroicon-m-plus'),
            ])
            ->actions([
                EditAction::make()
                    ->label('Edit'),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No answers yet')
            ->emptyStateDescription('Add the answer choices that quiz visitors will select from.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-ellipsis');
    }

    protected function handleRecordCreation(array $data): QuizAnswer
    {
        return $this->getRelationship()->create([
            'quiz_question_id' => $this->ownerRecord->id,
            'text' => $data['text'],
            'description' => $data['description'] ?? null,
            'order' => $data['order'] ?? 0,
        ]);
    }
}

