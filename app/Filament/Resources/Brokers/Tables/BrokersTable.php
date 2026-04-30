<?php

namespace App\Filament\Resources\Brokers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class BrokersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->getStateUsing(fn ($record): ?string => filled($record->logo)
                        ? preg_replace('#^(storage/app/public|public)/#', '', $record->logo)
                        : null)
                    ->disk('public')
                    ->label('')
                    ->square()
                    ->size(40),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->website),
                TextColumn::make('min_deposit')
                    ->label('Min. deposit')
                    ->sortable(),
                TextColumn::make('regulation')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                TextColumn::make('years_in_business')
                    ->label('Years')
                    ->sortable()
                    ->alignCenter(),
                TextColumn::make('rating')
                    ->label('Rating')
                    ->numeric()
                    ->sortable()
                    ->badge()
                    ->color(fn ($state): string => match (true) {
                        $state >= 4 => 'success',
                        $state >= 3 => 'info',
                        $state >= 2 => 'warning',
                        default => 'gray',
                    }),
                IconColumn::make('is_active')
                    ->label('Published')
                    ->boolean()
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                TernaryFilter::make('is_active')
                    ->label('Published')
                    ->trueLabel('Published only')
                    ->falseLabel('Drafts only'),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No brokers yet')
            ->emptyStateDescription('Add brokers to make them available in quiz results and recommendations.')
            ->emptyStateIcon('heroicon-o-briefcase');
    }
}
