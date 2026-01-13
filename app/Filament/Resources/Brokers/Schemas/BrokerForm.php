<?php

namespace App\Filament\Resources\Brokers\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class BrokerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->unique(ignoreRecord: true),
                Textarea::make('description')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('website')
                    ->url()
                    ->default(null),
                FileUpload::make('logo')
                    ->label('Logo')
                    ->image()
                    ->disk('public')
                    ->directory('brokers/logos')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->imageEditor(),
                TextInput::make('min_deposit')
                    ->numeric()
                    ->default(null),
                TextInput::make('regulation')
                    ->default(null),
                TextInput::make('years_in_business')
                    ->numeric()
                    ->default(null),
                TagsInput::make('features')
                    ->placeholder('Add a feature and press enter')
                    ->separator(','),
                TagsInput::make('pros')
                    ->placeholder('Add a pro and press enter')
                    ->separator(','),
                TagsInput::make('cons')
                    ->placeholder('Add a con and press enter')
                    ->separator(','),
                TextInput::make('rating')
                    ->numeric()
                    ->step(0.1)
                    ->default(null)
                    ->minValue(0)
                    ->maxValue(5),
                Toggle::make('is_active')
                    ->default(true)
                    ->required(),
            ]);
    }
}

