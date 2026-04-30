<?php

namespace App\Filament\Resources\QuizQuestions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class QuizQuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order')
                    ->label('#')
                    ->numeric()
                    ->sortable()
                    ->alignCenter()
                    ->width(48),
                TextColumn::make('title')
                    ->label('Question')
                    ->searchable()
                    ->description(fn ($record) => $record->description)
                    ->wrap()
                    ->weight('medium'),
                TextColumn::make('answers_count')
                    ->label('Answers')
                    ->counts('answers')
                    ->badge()
                    ->color('info')
                    ->alignCenter(),
                IconColumn::make('is_active')
                    ->label('Published')
                    ->boolean()
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('order')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Published')
                    ->trueLabel('Published only')
                    ->falseLabel('Drafts only'),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('Edit'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No quiz questions yet')
            ->emptyStateDescription('Create your first question to start building the broker-matching quiz.')
            ->emptyStateIcon('heroicon-o-question-mark-circle');
    }
}
