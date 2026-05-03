<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PackageResource\Pages;
use App\Forms\Components\EditableTagsInput;
use App\Models\Package;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;

class PackageResource extends Resource
{
    protected static ?string $model = Package::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCreditCard;
    protected static \UnitEnum|string|null $navigationGroup = 'Catalog';
    protected static ?string $navigationLabel = 'Packages';
    protected static ?int $navigationSort = 3;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Package details')
                    ->icon('heroicon-o-credit-card')
                    ->description('Define the name, min deposit, and what the package includes.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Package name')
                            ->placeholder('e.g. Starter, Pro, Premium')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('price')
                            ->label('Min deposit')
                            ->prefix('$')
                            ->numeric()
                            ->required()
                            ->minValue(0)
                            ->step(0.01)
                            ->placeholder('0.00'),
                        Textarea::make('description')
                            ->label('Package details')
                            ->placeholder('Briefly explain what this package offers.')
                            ->rows(4)
                            ->columnSpanFull(),
                        EditableTagsInput::make('facilities')
                            ->label('Facilities')
                            ->placeholder('Add a facility and press enter')
                            ->helperText('Click an existing facility to edit it. Use "," to add multiple facilities at once. Drag to reorder.')
                            ->reorderable()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Publishing')
                    ->icon('heroicon-o-rocket-launch')
                    ->description('Control whether this package is visible to customers.')
                    ->schema([
                        Placeholder::make('recommended_notice')
                            ->label('Recommended package notice')
                            ->content(function (callable $get, ?Package $record): string {
                                $existingRecommended = Package::query()
                                    ->where('is_recommended', true)
                                    ->when(
                                        $record,
                                        fn (Builder $query): Builder => $query->whereKeyNot($record->getKey())
                                    )
                                    ->first();

                                if (! $existingRecommended) {
                                    return $record?->is_recommended
                                        ? 'This package is currently the recommended package.'
                                        : 'No other package is currently marked as recommended.';
                                }

                                if ((bool) $get('is_recommended')) {
                                    return "{$existingRecommended->name} is currently recommended. Saving this package as recommended will remove that status from {$existingRecommended->name}.";
                                }

                                return "{$existingRecommended->name} is currently recommended. Turn on Recommended package to replace it when you save.";
                            })
                            ->columnSpanFull(),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->helperText('Inactive packages are hidden from the customer catalog.')
                            ->default(true)
                            ->inline(false)
                            ->columnSpanFull(),
                        Toggle::make('is_recommended')
                            ->label('Recommended package')
                            ->helperText('Only one package can be recommended at a time. If you enable this and save, the current recommended package will be updated automatically.')
                            ->default(false)
                            ->live()
                            ->inline(false)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->description(fn (Package $record): string => (string) ($record->description ?? 'No details added'))
                ->wrap(),
            TextColumn::make('price')
                ->label('Min deposit')
                ->money('usd')
                ->sortable(),
            TextColumn::make('facilities_count')
                ->label('Facilities')
                ->state(fn (Package $record): int => count($record->facilities ?? []))
                ->badge()
                ->color('gray'),
            TextColumn::make('is_recommended')
                ->label('Recommended')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Yes' : 'No')
                ->badge()
                ->color(fn (bool $state): string => $state ? 'warning' : 'gray'),
            TextColumn::make('is_active')
                ->label('Status')
                ->formatStateUsing(fn (bool $state): string => $state ? 'Active' : 'Inactive')
                ->badge()
                ->color(fn (bool $state): string => $state ? 'success' : 'danger'),
            TextColumn::make('created_at')
                ->label('Created')
                ->since()
                ->sortable(),
        ])
        ->filters([
            SelectFilter::make('is_active')
                ->label('Status')
                ->options([
                    '1' => 'Active',
                    '0' => 'Inactive',
                ]),
            Filter::make('price_range')
                ->label('Min deposit range')
                ->form([
                    TextInput::make('price_from')
                        ->label('Min deposit from')
                        ->numeric()
                        ->minValue(0)
                        ->placeholder('0'),
                    TextInput::make('price_to')
                        ->label('Min deposit to')
                        ->numeric()
                        ->minValue(0)
                        ->placeholder('1000'),
                ])
                ->query(function (Builder $query, array $data): Builder {
                    return $query
                        ->when(
                            filled($data['price_from'] ?? null),
                            fn (Builder $query): Builder => $query->where('price', '>=', (float) $data['price_from'])
                        )
                        ->when(
                            filled($data['price_to'] ?? null),
                            fn (Builder $query): Builder => $query->where('price', '<=', (float) $data['price_to'])
                        );
                }),
        ])->recordActions([
            \Filament\Actions\EditAction::make(),
        ])
        ->emptyStateHeading('No packages yet')
        ->emptyStateDescription('Create your first package to make it available to customers.')
        ->emptyStateIcon('heroicon-o-credit-card');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPackages::route('/'),
            'create' => Pages\CreatePackage::route('/create'),
            'edit' => Pages\EditPackage::route('/{record}/edit'),
        ];
    }
}
