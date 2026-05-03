<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers\UserPackagesRelationManager;
use App\Models\User;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUsers;
    protected static \UnitEnum|string|null $navigationGroup = 'User Management';
    protected static ?string $navigationLabel = 'All Customers';
    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Customer profile')
                    ->icon('heroicon-o-user')
                    ->description('The customer\'s display name and login credentials.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Full name')
                            ->placeholder('John Doe')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required()
                            ->minLength(8)
                            ->helperText('Minimum 8 characters.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Account status')
                    ->icon('heroicon-o-signal')
                    ->description('Managed automatically from this customer\'s package records.')
                    ->schema([
                        Placeholder::make('effective_status')
                            ->label('Current account status')
                            ->content(function (?User $record): string {
                                if (! $record) {
                                    return 'Registered';
                                }

                                return ucfirst(str_replace('_', ' ', $record->effective_status));
                            })
                            ->helperText('Update the package records below on the Edit Customer page to change this status.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->modifyQueryUsing(
            fn (Builder $query): Builder => $query
                ->with('latestUserPackage.package')
                ->withExists([
                    'userPackages as has_active_package' => fn (Builder $packageQuery): Builder => $packageQuery->whereIn('status', ['active', 'active_waiting']),
                ])
        )
        ->columns([
            TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->description(fn ($record) => $record->email),
            TextColumn::make('email')
                ->searchable()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('status')
                ->state(fn (User $record): string => $record->effective_status)
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'active' => 'success',
                    'expired' => 'danger',
                    'pending' => 'warning',
                    'registered' => 'gray',
                    default => 'gray',
                }),
            TextColumn::make('latestUserPackage.broker_name')
                ->label('Broker Credentials')
                ->placeholder('Not submitted')
                ->searchable()
                ->html()
                ->wrap()
                ->formatStateUsing(function (?string $state, User $record): HtmlString {
                    $package = $record->latestUserPackage;

                    if (! $package) {
                        return new HtmlString('<span style="color:#6b7280;">No broker credentials submitted yet.</span>');
                    }

                    $broker = e($state ?: 'N/A');
                    $tradingId = filled($package->trading_id) ? $package->trading_id : 'N/A';
                    $server = filled($package->trading_server) ? $package->trading_server : 'N/A';
                    $equity = isset($package->equity) ? '$' . number_format((float) $package->equity, 2) : 'N/A';
                    $packageName = e($package->package?->name ?? 'N/A');
                    $packageStatus = strtoupper((string) $package->status);

                    return new HtmlString(
                        '<div style="display:flex;flex-direction:column;gap:6px;line-height:1.35;">'
                        . '<div style="display:flex;align-items:center;gap:6px;flex-wrap:wrap;">'
                        . '<span style="font-weight:700;color:#111827;">' . $broker . '</span>'
                        . '<span style="font-size:11px;padding:2px 8px;border-radius:999px;border:1px solid #d1d5db;background:#f9fafb;color:#374151;">' . e($packageStatus) . '</span>'
                        . '</div>'
                        . '<div style="font-size:12px;color:#4b5563;">Package: <strong style="color:#1f2937;">' . $packageName . '</strong></div>'
                        . '<div style="font-size:12px;color:#374151;">Trading ID: <span style="font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace;">' . e($tradingId) . '</span></div>'
                        . '<div style="font-size:12px;color:#374151;">Server: <span style="font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace;">' . e($server) . '</span> | Equity: <strong>' . e($equity) . '</strong></div>'
                        . '</div>'
                    );
                })
                ->description(function (User $record): string {
                    if (! $record->latestUserPackage) {
                        return '';
                    }

                    return 'Latest submitted package credentials';
                }),
            TextColumn::make('created_at')
                ->label('Registered')
                ->dateTime('M d, Y')
                ->sortable(),
        ])
        ->defaultSort('created_at', 'desc')
        ->filters([
            SelectFilter::make('status')
                ->options([
                    'registered' => 'Registered',
                    'pending' => 'Pending Verify',
                    'active' => 'Active',
                    'expired' => 'Expired',
                ])
                ->label('Status')
                ->query(function (Builder $query, array $data): Builder {
                    $status = (string) ($data['value'] ?? '');

                    if ($status === '') {
                        return $query;
                    }

                    if ($status === 'active') {
                        return $query->where(function (Builder $statusQuery): void {
                            $statusQuery
                                ->where('status', 'active')
                                ->orWhereHas('userPackages', fn (Builder $packageQuery): Builder => $packageQuery->whereIn('status', ['active', 'active_waiting']));
                        });
                    }

                    return $query
                        ->where('status', $status)
                        ->whereDoesntHave('userPackages', fn (Builder $packageQuery): Builder => $packageQuery->whereIn('status', ['active', 'active_waiting']));
                }),
        ])
        ->recordActions([
            Action::make('editPackageDetails')
                ->label('Package Details')
                ->icon('heroicon-o-credit-card')
                ->color('gray')
                ->url(fn (User $record): string => static::getUrl('edit', ['record' => $record]))
                ->tooltip('Open the customer and manage package details in the package panel.'),
            EditAction::make()
                ->label('Edit Customer'),
            \Filament\Actions\DeleteAction::make(),
        ])
        ->emptyStateHeading('No customers yet')
        ->emptyStateDescription('Add the first customer account manually or wait for registrations.')
        ->emptyStateIcon('heroicon-o-users');
    }

    public static function getRelations(): array
    {
        return [
            UserPackagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
