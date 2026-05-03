<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdminResource\Pages;
use App\Models\Admin;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;

class AdminResource extends Resource
{
    protected static ?string $model = Admin::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;
    protected static \UnitEnum|string|null $navigationGroup = 'Settings & Others';
    protected static ?string $navigationLabel = 'Administrators';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Administrator details')
                    ->icon('heroicon-o-user')
                    ->description('Name and login credentials for this admin account.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full name')
                            ->placeholder('Jane Smith')
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
                            ->dehydrateStateUsing(fn ($state) => $state ? bcrypt($state) : null)
                            ->required(fn ($livewire, $context) => $context === 'create')
                            ->helperText('Leave blank when editing to keep the current password.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Access')
                    ->icon('heroicon-o-shield-check')
                    ->description('Role and login permission for this account.')
                    ->schema([
                        Select::make('role')
                            ->options([
                                'super' => 'Super Admin',
                                'general' => 'General Admin',
                                'moderator' => 'Moderator',
                            ])
                            ->required()
                            ->helperText('Determines what this admin can manage.')
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Active account')
                            ->helperText('Inactive admins cannot log in to the panel.')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->description(fn ($record) => $record->email),
                TextColumn::make('role')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'super' => 'danger',
                        'general' => 'info',
                        'moderator' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->alignCenter(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('name')
            ->filters([
                SelectFilter::make('role')
                    ->options([
                        'super' => 'Super Admin',
                        'general' => 'General Admin',
                        'moderator' => 'Moderator',
                    ]),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->emptyStateHeading('No administrators yet')
            ->emptyStateDescription('Add the first admin account to give someone access to this panel.')
            ->emptyStateIcon('heroicon-o-shield-check');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdmins::route('/'),
            'create' => Pages\CreateAdmin::route('/create'),
            'edit' => Pages\EditAdmin::route('/{record}/edit'),
        ];
    }
}
