<?php

namespace App\Filament\Resources\QuizQuestions\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\RelationManagers\RelationManager;
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
        return $schema->components([
            TextInput::make('text')
                ->label('Answer Text')
                ->required()
                ->maxLength(255),
            Textarea::make('description')
                ->label('Description (optional)')
                ->columnSpanFull(),
            TextInput::make('order')
                ->label('Order')
                ->numeric()
                ->default(0),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('text')
                    ->searchable()
                    ->label('Answer'),
                TextColumn::make('order')
                    ->numeric()
                    ->sortable()
                    ->label('Order'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()
                    ->label('Add Answer'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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

