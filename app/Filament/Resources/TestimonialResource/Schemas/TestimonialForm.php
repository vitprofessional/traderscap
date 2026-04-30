<?php

namespace App\Filament\Resources\TestimonialResource\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TestimonialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Author & quote')
                    ->icon('heroicon-o-user-circle')
                    ->description('The customer\'s details and testimonial text.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Customer name')
                            ->placeholder('Sarah Johnson')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('company')
                            ->label('Company')
                            ->placeholder('Acme Trading Ltd')
                            ->maxLength(255),
                        TextInput::make('position')
                            ->label('Position / title')
                            ->placeholder('Senior Trader')
                            ->maxLength(255),
                        Textarea::make('message')
                            ->label('Testimonial text')
                            ->placeholder('Write the customer\'s testimonial here…')
                            ->required()
                            ->rows(5)
                            ->columnSpanFull(),
                        FileUpload::make('avatar')
                            ->label('Author photo')
                            ->image()
                            ->disk('public')
                            ->directory('testimonials')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->helperText('Square crop recommended. JPG or PNG.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Publishing')
                    ->icon('heroicon-o-rocket-launch')
                    ->description('Control visibility and display order.')
                    ->schema([
                        TextInput::make('order')
                            ->label('Display order')
                            ->helperText('Lower numbers appear first on the website.')
                            ->numeric()
                            ->default(0)
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Published')
                            ->helperText('Unpublished testimonials are hidden from the public.')
                            ->default(true)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }
}
