<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use App\Models\Package;
use App\Models\UserPackage;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\DateTimePicker;
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

    public static function canViewForRecord(\Illuminate\Database\Eloquent\Model $ownerRecord, string $pageClass): bool
    {
        $accountStatus = (string) ($ownerRecord->fresh()?->account_status ?? $ownerRecord->account_status ?? 'registered');

        if ($accountStatus !== 'active') {
            return false;
        }

        return parent::canViewForRecord($ownerRecord, $pageClass);
    }

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
                            ->label('Package Name')
                            ->searchable()
                            ->live()
                            ->afterStateUpdated(function ($state, Set $set): void {
                                if (blank($state)) {
                                    return;
                                }

                                $minDeposit = (float) (Package::query()->whereKey($state)->value('price') ?? 0);
                                $set('equity', $minDeposit);
                            })
                            ->required()
                            ->columnSpanFull(),
                        DateTimePicker::make('starts_at')
                            ->label('Activation Date')
                            ->seconds(false)
                            ->native(false)
                            ->default(now())
                            ->displayFormat('M d, Y H:i')
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
                    ->description('Package lifecycle state only. This does not control account access status.')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'active' => 'Active',
                                'active_waiting' => 'Active Waiting',
                                'expired' => 'Expired',
                                'pending' => 'Pending',
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
                            ->label('MT4/MT5 ID')
                            ->maxLength(255),
                        TextInput::make('trading_password')
                            ->label('MT4/MT5 Password')
                            ->maxLength(255),
                        TextInput::make('trading_server')
                            ->label('Server')
                            ->maxLength(255),
                        TextInput::make('equity')
                            ->label('Deposit Amount/Equity')
                            ->numeric()
                            ->prefix('$')
                            ->required()
                            ->minValue(fn (Get $get): float => (float) (Package::query()->whereKey($get('package_id'))->value('price') ?? 0))
                            ->helperText(fn (Get $get): string => 'Must be at least the selected package minimum deposit: $' . number_format((float) (Package::query()->whereKey($get('package_id'))->value('price') ?? 0), 2))
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
                    ->label('Package Name')
                    ->searchable()
                    ->description(fn (UserPackage $record): string => $record->package
                        ? '$' . number_format($record->package->price, 0) . ($record->package->is_recommended ? ' · ★ Recommended' : '')
                        : '—'
                    ),
                TextColumn::make('starts_at')
                    ->label('Activation Date')
                    ->dateTime('M d, Y H:i')
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable()
                    ->color(fn (string $state): string => match ($state) {
                        'active', 'active_waiting' => 'success',
                        'pending' => 'warning',
                        'expired' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('broker_name')
                    ->label('Broker Name')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trading_id')
                    ->label('MT4/MT5 ID')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trading_password')
                    ->label('MT4/MT5 Password')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('trading_server')
                    ->label('Server')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('equity')
                    ->label('Deposit Amount/Equity')
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
                        'active' => 'Active',
                        'active_waiting' => 'Active Waiting',
                        'expired' => 'Expired',
                        'pending' => 'Pending',
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
                            'starts_at' => $userPackage->starts_at,
                            'status' => $userPackage->status,
                            'broker_name' => $userPackage->broker_name,
                            'trading_id' => $userPackage->trading_id,
                            'trading_password' => $userPackage->trading_password,
                            'trading_server' => $userPackage->trading_server,
                            'equity' => $userPackage->equity,
                        ];
                    })
                    ->form($this->getPackageDetailsFormComponents())
                    ->action(function (array $data): void {
                        $ownerRecord = $this->getOwnerRecord();
                        $userPackage = $ownerRecord->userPackages()->latest('id')->first();

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
