<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserPackageResource\Pages;
use App\Models\UserPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Str;
use App\Models\Package;
use Carbon\Carbon;
use Filament\Forms\Components\Placeholder;

class UserPackageResource extends Resource
{
    protected static ?string $model = UserPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;
    protected static \UnitEnum|string|null $navigationGroup = 'Users';
    protected static ?string $navigationLabel = 'User Packages';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Subscription')
                    ->icon('heroicon-o-rectangle-stack')
                    ->description('The customer and package for this subscription.')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Customer')
                            ->searchable()
                            ->required()
                            ->helperText('The customer this package is assigned to.')
                            ->columnSpanFull(),
                        Select::make('package_id')
                            ->relationship('package', 'name')
                            ->label('Package')
                            ->searchable()
                            ->required()
                            ->live()
                            ->helperText('Selecting a package will auto-fill the start and end dates.')
                            ->afterStateUpdated(function ($state, callable $set) {
                                if (!$state) {
                                    return;
                                }

                                $package = Package::find($state);
                                if (!$package) {
                                    return;
                                }

                                // Set starts_at to today
                                $set('starts_at', Carbon::today());

                                // Set ends_at based on duration_days
                                if ($package->duration_days) {
                                    $set('ends_at', Carbon::today()->addDays($package->duration_days));
                                }
                            })
                            ->afterStateHydrated(function ($state, callable $set, $record) {
                                if (!$state || !$record) {
                                    return;
                                }

                                // If starts_at or ends_at are empty, fill them based on package duration
                                $package = Package::find($state);
                                if (!$package) {
                                    return;
                                }

                                if (!$record->starts_at) {
                                    $set('starts_at', Carbon::today());
                                }

                                if (!$record->ends_at && $package->duration_days) {
                                    $set('ends_at', Carbon::today()->addDays($package->duration_days));
                                }
                            })
                            ->columnSpanFull(),
                        Placeholder::make('package_summary')
                            ->label('Package summary')
                            ->content(function ($get): string {
                                $packageId = $get('package_id');
                                if (!$packageId) {
                                    return 'Select a package above to see its details.';
                                }
                                $package = Package::find($packageId);
                                if (!$package) {
                                    return '—';
                                }
                                $price = '$' . number_format($package->price, 0) . ' min deposit';
                                $duration = $package->duration_label;
                                $recommended = $package->is_recommended ? ' · ★ Recommended' : '';
                                $facilitiesArr = is_array($package->facilities) ? $package->facilities : [];
                                $facilities = !empty($facilitiesArr) ? implode(', ', $facilitiesArr) : 'No facilities listed';
                                return "{$price} · {$duration}{$recommended} — {$facilities}";
                            })
                            ->columnSpanFull(),
                        DatePicker::make('starts_at')
                            ->label('Start date')
                            ->helperText('Auto-set when a package is selected.'),
                        DatePicker::make('ends_at')
                            ->label('End date')
                            ->helperText('Auto-calculated from the package duration.'),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Status')
                    ->icon('heroicon-o-signal')
                    ->description('Current lifecycle state of this subscription.')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'registered' => 'Registered',
                                'pending' => 'Pending Verify',
                                'active_waiting' => 'Active Waiting',
                                'active' => 'Active',
                                'expired' => 'Expired',
                            ])
                            ->required()
                            ->helperText('Changing status here also updates dates in the table.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
                Section::make('Trading credentials')
                    ->icon('heroicon-o-key')
                    ->description('Broker account details provided to the customer.')
                    ->columns(2)
                    ->schema([
                        TextInput::make('broker_name')
                            ->label('Broker name')
                            ->placeholder('e.g. XM, eToro')
                            ->maxLength(255),
                        TextInput::make('trading_id')
                            ->label('Trading account ID')
                            ->maxLength(255),
                        TextInput::make('trading_password')
                            ->label('Trading password')
                            ->password()
                            ->maxLength(255),
                        TextInput::make('trading_server')
                            ->label('Trading server')
                            ->placeholder('e.g. XM-Real2')
                            ->maxLength(255),
                        TextInput::make('equity')
                            ->label('Equity (USD)')
                            ->numeric()
                            ->prefix('$')
                            ->minValue(0)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('User')->searchable(),
            TextColumn::make('package.name')
                ->label('Package')
                ->searchable()
                ->description(fn (UserPackage $record): string => $record->package
                    ? '$' . number_format($record->package->price, 0) . ' · ' . $record->package->duration_label . ($record->package->is_recommended ? ' · ★ Recommended' : '')
                    : '—'
                ),
            TextColumn::make('broker_name')->label('Broker')->searchable()->toggleable(),
            TextColumn::make('trading_id')->label('Trading ID')->searchable()->toggleable(),
            TextColumn::make('trading_server')->label('Server')->searchable()->toggleable(),
            TextColumn::make('equity')->money('usd')->toggleable(),
            TextColumn::make('starts_at')->date()->sortable(),
            TextColumn::make('ends_at')->date()->sortable(),
            SelectColumn::make('status')
                ->options([
                    'registered' => 'Registered',
                    'pending' => 'Pending Verify',
                    'active_waiting' => 'Active Waiting',
                    'active' => 'Active',
                    'expired' => 'Expired',
                    'cancelled' => 'Cancelled',
                ])
                ->sortable()
                ->afterStateUpdated(function ($record, $state) {
                    $record->status = $state;

                    // Update dates based on new status
                    if ($state === 'active' || $state === 'active_waiting') {
                        $record->starts_at = Carbon::today();
                        if ($record->package && $record->package->duration_days) {
                            $record->ends_at = Carbon::today()->addDays($record->package->duration_days);
                        }
                    } elseif ($state === 'pending') {
                        // For pending, set starts_at to today and calculate ends_at
                        $record->starts_at = Carbon::today();
                        if ($record->package && $record->package->duration_days) {
                            $record->ends_at = Carbon::today()->addDays($record->package->duration_days);
                        }
                    } elseif ($state === 'expired') {
                        // For expired, set ends_at to today
                        $record->ends_at = Carbon::today();
                    } elseif ($state === 'registered' || $state === 'cancelled') {
                        // For registered/cancelled, clear the dates
                        $record->starts_at = null;
                        $record->ends_at = null;
                    }

                    $record->save();
                }),
        ])->filters([
            SelectFilter::make('status')
                ->options([
                    'registered' => 'Registered',
                    'pending' => 'Pending Verify',
                    'active_waiting' => 'Active Waiting',
                    'active' => 'Active',
                    'expired' => 'Expired',
                    'cancelled' => 'Cancelled',
                ])
                ->label('Status'),
        ])->defaultSort('created_at', 'desc')
        ->recordActions([
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ])
        ->emptyStateHeading('No user packages yet')
        ->emptyStateDescription('Assign a package to a customer to get started.')
        ->emptyStateIcon('heroicon-o-cube')
        ->toolbarActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
                BulkAction::make('expireSelected')
                    ->label('Expire Selected')
                    ->requiresConfirmation()
                    ->action(function (\Illuminate\Support\Collection $records) {
                        $count = 0;
                        foreach ($records as $record) {
                            try {
                                $record->status = 'expired';
                                $record->save();

                                // notify the user
                                if ($record->user) {
                                    $record->user->notify(new \App\Notifications\PackageExpiredNotification($record));
                                }

                                // update user status if no active packages
                                if ($record->user) {
                                    $hasActive = $record->user->userPackages()->where('status', 'active')->exists();
                                    if (! $hasActive) {
                                        $record->user->status = 'expired';
                                        $record->user->save();
                                    }
                                }

                                $count++;
                            } catch (\Throwable $e) {
                                report($e);
                            }
                        }

                        \Filament\Notifications\Notification::make()
                            ->title($count . ' package(s) expired')
                            ->success()
                            ->send();
                    }),
            ]),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserPackages::route('/'),
            'create' => Pages\CreateUserPackage::route('/create'),
            'edit' => Pages\EditUserPackage::route('/{record}/edit'),
        ];
    }
}
