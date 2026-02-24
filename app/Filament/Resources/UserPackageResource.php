<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserPackageResource\Pages;
use App\Models\UserPackage;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Str;
use App\Models\Package;
use Carbon\Carbon;

class UserPackageResource extends Resource
{
    protected static ?string $model = UserPackage::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;
    protected static \UnitEnum|string|null $navigationGroup = 'Users';
    protected static ?string $navigationLabel = 'User Packages';
    protected static ?int $navigationSort = 6;

    public static function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('user_id')->relationship('user', 'name')->searchable()->required(),
            Select::make('package_id')
                ->relationship('package', 'name')
                ->searchable()
                ->required()
                ->live()
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
                }),
            TextInput::make('broker_name')->maxLength(255),
            TextInput::make('trading_id')->maxLength(255),
            TextInput::make('trading_password')->maxLength(255),
            TextInput::make('trading_server')->maxLength(255),
            TextInput::make('equity')->numeric()->minValue(0),
            DatePicker::make('starts_at'),
            DatePicker::make('ends_at'),
            Select::make('status')->options([
                'registered' => 'Registered',
                'pending' => 'Pending Verify',
                'active_waiting' => 'Active Waiting',
                'active' => 'Active',
                'expired' => 'Expired',
            ])->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('User')->searchable(),
            TextColumn::make('package.name')->label('Package')->searchable(),
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
        ])->recordActions([
            \Filament\Actions\EditAction::make(),
            \Filament\Actions\DeleteAction::make(),
        ])->toolbarActions([
            \Filament\Actions\CreateAction::make(),
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
