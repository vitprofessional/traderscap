<?php

namespace App\Filament\Resources\Brokers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class BrokerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Broker identity')
                    ->icon('heroicon-o-building-office')
                    ->description('Name, website, description, and logo for this broker.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Broker name')
                            ->placeholder('e.g. XM Trading, eToro')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        TextInput::make('website')
                            ->label('Website URL')
                            ->url()
                            ->placeholder('https://www.broker.com')
                            ->default(null)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Short description')
                            ->placeholder('A brief overview of this broker and what they offer.')
                            ->rows(4)
                            ->default(null)
                            ->columnSpanFull(),
                        FileUpload::make('logo')
                            ->label('Broker logo')
                            ->image()
                            ->disk('public')
                            ->directory('brokers/logos')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->imageEditor()
                            ->helperText('PNG or SVG on a white or transparent background.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Details & publishing')
                    ->icon('heroicon-o-chart-bar')
                    ->description('Trading details, rating, and active status.')
                    ->schema([
                        TextInput::make('min_deposit')
                            ->label('Minimum deposit')
                            ->placeholder('e.g. $100, No minimum')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('regulation')
                            ->label('Regulation')
                            ->placeholder('e.g. FCA, CySEC, ASIC')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('years_in_business')
                            ->label('Years in business')
                            ->placeholder('e.g. 15, 15+')
                            ->default(null)
                            ->columnSpanFull(),
                        TextInput::make('rating')
                            ->label('Rating (0–5)')
                            ->numeric()
                            ->step(0.1)
                            ->default(null)
                            ->minValue(0)
                            ->maxValue(5)
                            ->helperText('Displayed as a star rating on the public page.')
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Published')
                            ->helperText('Only published brokers appear in quiz results.')
                            ->default(true)
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
                Section::make('Features, pros & cons')
                    ->icon('heroicon-o-list-bullet')
                    ->description('Key features and talking points for quiz matching and the public profile.')
                    ->columns(3)
                    ->schema([
                        TagsInput::make('features')
                            ->label('Features')
                            ->placeholder('Add a feature and press Enter')
                            ->helperText('e.g. MetaTrader 4, Copy Trading, Demo Account')
                            ->separator(','),
                        TagsInput::make('pros')
                            ->label('Pros')
                            ->placeholder('Add a pro and press Enter')
                            ->separator(','),
                        TagsInput::make('cons')
                            ->label('Cons')
                            ->placeholder('Add a con and press Enter')
                            ->separator(','),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
