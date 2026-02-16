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
use Filament\Support\Icons\Heroicon;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Illuminate\Support\Str;

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
            Select::make('package_id')->relationship('package', 'name')->searchable()->required(),
            DatePicker::make('starts_at'),
            DatePicker::make('ends_at'),
            Select::make('status')->options([
                'registered' => 'Registered',
                'pending' => 'Pending Verify',
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
            TextColumn::make('starts_at')->date()->sortable(),
            TextColumn::make('ends_at')->date()->sortable(),
            TextColumn::make('status')->sortable(),
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
