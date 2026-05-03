<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Package;
use App\Models\UserPackage;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class UserPackagesRelationManager extends RelationManager
{
    protected static string $relationship = 'userPackages';

    protected static ?string $recordTitleAttribute = 'id';

    protected static ?string $title = 'Package Details';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components($this->getPackageDetailsFormComponents());
    }

    protected function getPackageDetailsFormComponents(): array
    {
        return [
                Section::make('Subscription')
                    ->icon('heroicon-o-rectangle-stack')
                    ->description('Assign and manage package details for this customer.')
                    ->schema([
                        Select::make('package_id')
                            ->relationship('package', 'name')
                            ->label('Package')
                            ->searchable()
                            ->required()
                            ->columnSpanFull(),
                        Placeholder::make('package_summary')
                            ->label('Package summary')
                            ->content(function ($get): string {
                                $packageId = $get('package_id');

                                if (! $packageId) {
                                    return 'Select a package above to see its details.';
                                }

                                $package = Package::find($packageId);

                                if (! $package) {
                                    return '—';
                                }

                                $price = '$' . number_format($package->price, 0) . ' min deposit';
                                $recommended = $package->is_recommended ? ' · ★ Recommended' : '';
                                $facilities = is_array($package->facilities) && ! empty($package->facilities)
                                    ? implode(', ', $package->facilities)
                                    : 'No facilities listed';

                                return "{$price}{$recommended} — {$facilities}";
                            })
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Status')
                    ->icon('heroicon-o-signal')
                    ->description('Package lifecycle state. Account status updates automatically from this.')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'registered' => 'Registered',
                                'pending' => 'Pending Verify',
                                'active_waiting' => 'Active Waiting',
                                'active' => 'Active',
                                'expired' => 'Expired',
                                'cancelled' => 'Cancelled',
                            ])
                            ->required()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
                Section::make('Trading credentials')
                    ->icon('heroicon-o-key')
                    ->description('Broker account details attached to this package.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('broker_name')
                            ->label('Broker name')
                            ->maxLength(255),
                        TextInput::make('trading_id')
                            ->label('Trading account ID')
                            ->maxLength(255),
                        TextInput::make('trading_password')
                            ->label('Trading password')
                            ->password()
                            ->revealable()
                            ->helperText('Leave blank to keep the current password when editing.')
                            ->maxLength(255),
                        TextInput::make('trading_server')
                            ->label('Trading server')
                            ->maxLength(255),
                        TextInput::make('equity')
                            ->label('Equity (USD)')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
                    ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('package.name')
            ->columns([
                TextColumn::make('package.name')
                    ->label('Package')
                    ->searchable()
                    ->description(fn (UserPackage $record): string => $record->package
                        ? '$' . number_format($record->package->price, 0) . ($record->package->is_recommended ? ' · ★ Recommended' : '')
                        : '—'
                    ),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'active', 'active_waiting' => 'success',
                        'pending' => 'warning',
                        'expired', 'cancelled' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('broker_name')
                    ->label('Broker')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trading_id')
                    ->label('Trading ID')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trading_server')
                    ->label('Server')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('equity')
                    ->money('usd')
                    ->toggleable(),
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'registered' => 'Registered',
                        'pending' => 'Pending Verify',
                        'active_waiting' => 'Active Waiting',
                        'active' => 'Active',
                        'expired' => 'Expired',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->headerActions([
                Action::make('editPackageDetails')
                    ->label(fn (): string => $this->getOwnerRecord()->userPackages()->exists()
                        ? 'Edit Package Details'
                        : 'Add Package Details')
                    ->icon('heroicon-o-pencil-square')
                    ->slideOver()
                    ->modalHeading(fn (): string => $this->getOwnerRecord()->userPackages()->exists()
                        ? 'Edit Package Details'
                        : 'Add Package Details')
                    ->fillForm(function (): array {
                        $userPackage = $this->getOwnerRecord()->userPackages()->latest('id')->first();

                        if (! $userPackage) {
                            return [];
                        }

                        return [
                            'package_id' => $userPackage->package_id,
                            'status' => $userPackage->status,
                            'broker_name' => $userPackage->broker_name,
                            'trading_id' => $userPackage->trading_id,
                            'trading_password' => null,
                            'trading_server' => $userPackage->trading_server,
                            'equity' => $userPackage->equity,
                        ];
                    })
                    ->form($this->getPackageDetailsFormComponents())
                    ->action(function (array $data): void {
                        $ownerRecord = $this->getOwnerRecord();
                        $userPackage = $ownerRecord->userPackages()->latest('id')->first();

                        if (blank($data['trading_password'] ?? null)) {
                            unset($data['trading_password']);
                        }

                        if ($userPackage) {
                            $userPackage->update($data);

                            return;
                        }

                        $ownerRecord->userPackages()->create($data);
                    }),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ]);
    }
}
