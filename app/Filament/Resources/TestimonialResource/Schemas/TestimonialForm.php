<?php

namespace App\Filament\Resources\TestimonialResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('company')
                ->maxLength(255),
            TextInput::make('position')
                ->maxLength(255),
            Textarea::make('message')
                ->required()
                ->rows(5),
            FileUpload::make('avatar')
                ->image()
                ->disk('public')
                ->directory('testimonials')
                ->visibility('public')
                ->preserveFilenames(),
            Toggle::make('is_active')
                ->label('Active')
                ->default(true),
            TextInput::make('order')
                ->numeric()
                ->default(0),
        ]);
    }
}
