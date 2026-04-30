<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\UserPackagesRelationManager;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;

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
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Customer profile')
                    ->icon('heroicon-o-user')
                    ->description('The customer\'s display name and login credentials.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full name')
                            ->placeholder('John Doe')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->helperText('Minimum 8 characters.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Account status')
                    ->icon('heroicon-o-signal')
                    ->description('Current lifecycle state of this account.')
                    ->schema([
                        Select::make('status')
                            ->options([
                                'registered' => 'Registered',
                                'pending' => 'Pending Verify',
                                'active' => 'Active',
                                'expired' => 'Expired',
                            ])
                            ->default('registered')
                            ->required()
                            ->helperText('Controls what the customer can access.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->description(fn ($record) => $record->email),
            TextColumn::make('email')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'expired' => 'danger',
                    'pending' => 'warning',
                    'registered' => 'gray',
                    default => 'gray',
                })
                ->sortable(),
            TextColumn::make('created_at')
                ->label('Registered')
                ->dateTime('M d, Y')
                ->sortable(),
        ])
        ->defaultSort('created_at', 'desc')
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
                ->icon('heroicon-m-arrows-right-left')
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
        ->emptyStateHeading('No customers yet')
        ->emptyStateDescription('Add the first customer account manually or wait for registrations.')
        ->emptyStateIcon('heroicon-o-users');
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
