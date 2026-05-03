<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CountryResource\Pages;
use App\Models\Country;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;

class CountryResource extends Resource
{
    protected static ?string $model = Country::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;
    protected static \UnitEnum|string|null $navigationGroup = 'Settings & Others';
    protected static ?string $navigationLabel = 'Countries';
    protected static ?int $navigationSort = 2;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 2])
            ->components([
                Section::make('Country details')
                    ->icon('heroicon-o-globe-alt')
                    ->description('Identity, ISO codes, and contact prefix for this country.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Country name')
                            ->placeholder('United States')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('iso2')
                            ->label('ISO 2 code')
                            ->placeholder('US')
                            ->helperText('2-letter country code (e.g. US, GB, DE).')
                            ->maxLength(2),
                        TextInput::make('iso3')
                            ->label('ISO 3 code')
                            ->placeholder('USA')
                            ->helperText('3-letter country code (e.g. USA, GBR, DEU).')
                            ->maxLength(3),
                        TextInput::make('code')
                            ->label('Numeric / regional code')
                            ->helperText('Optional. Used for regional grouping.')
                            ->maxLength(10),
                        TextInput::make('phone_code')
                            ->label('Phone prefix')
                            ->placeholder('+1')
                            ->helperText('International dialing prefix including the + sign.')
                            ->maxLength(10),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Inactive countries will not appear in dropdowns.')
                            ->default(true)
                            ->columnSpanFull(),
                    ]),
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
                    ->description(fn ($record) => $record->phone_code ? 'Phone: ' . $record->phone_code : null),
                TextColumn::make('iso2')
                    ->label('ISO2')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('iso3')
                    ->label('ISO3')
                    ->badge()
                    ->color('gray')
                    ->sortable(),
                TextColumn::make('phone_code')
                    ->label('Phone')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active')
                    ->alignCenter(),
            ])
            ->defaultSort('name')
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->emptyStateHeading('No countries yet')
            ->emptyStateDescription('Add countries to make them available in address and user forms.')
            ->emptyStateIcon('heroicon-o-globe-alt');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCountries::route('/'),
            'create' => Pages\CreateCountry::route('/create'),
            'edit' => Pages\EditCountry::route('/{record}/edit'),
        ];
    }
}
