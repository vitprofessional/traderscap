<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\UserPackagesRelationManager;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\Action;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static \UnitEnum|string|null $navigationGroup = 'Users';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')->required()->maxLength(255),
            TextInput::make('email')->email()->required()->unique(ignoreRecord: true),
            TextInput::make('password')->password()->required()->minLength(8),
            Select::make('status')
                ->options([
                    'registered' => 'Registered',
                    'pending' => 'Pending Verify',
                    'active' => 'Active',
                    'expired' => 'Expired',
                ])
                ->default('registered')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')->searchable()->sortable(),
            TextColumn::make('email')->searchable()->sortable(),
            TextColumn::make('status')->sortable(),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ])
        ->filters([
            SelectFilter::make('status')
                ->options([
                    'registered' => 'Registered',
                    'pending' => 'Pending Verify',
                    'active' => 'Active',
                    'expired' => 'Expired',
                ])
                ->label('Status'),
        ])
        ->recordActions([
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
            Action::make('changeStatus')
                ->label('Change Status')
                ->form([
                    Select::make('status')
                        ->options([
                            'registered' => 'Registered',
                            'pending' => 'Pending Verify',
                            'active' => 'Active',
                            'expired' => 'Expired',
                        ])
                        ->required(),
                ])
                ->action(function ($record, array $data) {
                    $record->status = $data['status'];
                    $record->save();
                }),
        ])
        ->toolbarActions([
            \Filament\Actions\CreateAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            UserPackagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
