<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;

class UserPackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'userPackages';

    protected static ?string $recordTitleAttribute = 'id';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            // handled by UserPackageResource if needed
        ]);
    }

    public function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('package.name')->label('Package')->searchable(),
            TextColumn::make('starts_at')->date()->sortable(),
            TextColumn::make('ends_at')->date()->sortable(),
            TextColumn::make('status')->sortable(),
        ])->actions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
    }
}
