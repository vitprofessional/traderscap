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
use App\Models\Package;
use App\Models\UserPackage;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
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
                Section::make('User Details')
                    ->icon('heroicon-o-user')
                    ->description('Core profile and login information for this customer.')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->placeholder('John Doe')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->columnSpanFull(),
                        Select::make('country_id')
                            ->label('Country')
                            ->relationship(
                                name: 'country',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)->orderBy('name')
                            )
                            ->searchable()
                            ->preload()
                            ->columnSpan(1),
                        TextInput::make('phone')
                            ->label('Mobile')
                            ->tel()
                            ->maxLength(30)
                            ->placeholder('+1 555 000 1234')
                            ->columnSpan(1),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->required(fn ($livewire, $context) => $context === 'create')
                            ->dehydrated(fn ($state): bool => filled($state))
                            ->minLength(8)
                            ->helperText('Leave blank on edit to keep the current password. Minimum 8 characters when set.')
                            ->columnSpanFull(),
                        Placeholder::make('registration_date')
                            ->label('Registration Date')
                            ->content(fn (?User $record): string => $record?->created_at?->format('M d, Y h:i A') ?? 'Auto generated when the account is created')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Account status')
                    ->icon('heroicon-o-signal')
                    ->description('Admin-managed customer account status.')
                    ->schema([
                        Select::make('account_status')
                            ->label('Current account status')
                            ->options([
                                'active' => 'Active',
                                'registered' => 'Register',
                                'banned' => 'Banned',
                            ])
                            ->default('registered')
                            ->required()
                            ->helperText(function (?User $record): string {
                                $baseMessage = 'If set to Register or Banned, last linked package data is removed for this profile.';

                                if (! $record) {
                                    return $baseMessage;
                                }

                                if (in_array((string) $record->account_status, ['registered', 'banned'], true)) {
                                    return 'Package details are hidden for Register/Banned users. Set status to Active to manage package details. ' . $baseMessage;
                                }

                                return $baseMessage;
                            })
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
                ->addSelect([
                    'users.*',
                    DB::raw('EXISTS(SELECT 1 FROM user_packages WHERE user_packages.user_id = users.id AND user_packages.status = "active") as has_active_package'),
                    DB::raw('EXISTS(SELECT 1 FROM user_packages WHERE user_packages.user_id = users.id AND user_packages.status = "active_waiting") as has_active_waiting_package'),
                    DB::raw('EXISTS(SELECT 1 FROM user_packages WHERE user_packages.user_id = users.id AND user_packages.status = "pending") as has_pending_package'),
                ])
        )
        ->columns([
            TextColumn::make('name')
                ->label('Customer Details')
                ->searchable()
                ->sortable()
                ->html()
                ->wrap()
                ->formatStateUsing(function (?string $state, User $record): HtmlString {
                    $name    = e($record->name ?? '—');
                    $email   = e($record->email ?? '');
                    $phone   = filled($record->phone) ? e($record->phone) : null;
                    $country = e($record->country?->name ?? '');

                    $lines = '<div style="display:flex;flex-direction:column;gap:3px;line-height:1.4;">';
                    $lines .= '<span style="font-weight:700;color:#111827;font-size:13px;">' . $name . '</span>';
                    if ($email) {
                        $lines .= '<span style="font-size:12px;color:#6b7280;">' . $email . '</span>';
                    }
                    if ($phone) {
                        $lines .= '<span style="font-size:12px;color:#6b7280;">' . $phone . '</span>';
                    }
                    if ($country) {
                        $lines .= '<span style="font-size:11px;color:#9ca3af;">' . $country . '</span>';
                    }
                    $lines .= '</div>';

                    return new HtmlString($lines);
                }),
            TextColumn::make('status')
                ->label('Account Status')
                ->state(function (User $record): string {
                    $accountStatus = (string) $record->account_status;

                    if (in_array($accountStatus, ['banned', 'registered'], true)) {
                        return $accountStatus;
                    }

                    // account_status = 'active' — derive sub-status from package records
                    if ($record->has_active_package) {
                        return 'active';
                    }

                    if ($record->has_active_waiting_package) {
                        return 'active_waiting';
                    }

                    if ($record->has_pending_package) {
                        return 'pending';
                    }

                    return 'active';
                })
                ->formatStateUsing(fn (?string $state): string => match ($state) {
                    'active'         => 'Active',
                    'active_waiting' => 'Active Waiting',
                    'pending'        => 'Pending Verify',
                    'banned'         => 'Banned',
                    'registered'     => 'Register',
                    default          => ucfirst((string) $state),
                })
                ->badge()
                ->color(fn (?string $state): string => match ($state) {
                    'active'         => 'success',
                    'active_waiting' => 'warning',
                    'pending'        => 'info',
                    'banned'         => 'danger',
                    'registered'     => 'gray',
                    default          => 'gray',
                }),
            TextColumn::make('latestUserPackage.broker_name')
                ->label('Broker Credentials')
                ->placeholder('Not submitted')
                ->searchable()
                ->html()
                ->wrap()
                ->formatStateUsing(function (?string $state, User $record): HtmlString {
                    if (in_array((string) $record->account_status, ['registered', 'banned'], true)) {
                        return new HtmlString('<span style="color:#6b7280;">No details found</span>');
                    }

                    $package = $record->latestUserPackage;

                    if (! $package) {
                        return new HtmlString('<span style="color:#6b7280;">No broker credentials submitted yet.</span>');
                    }

                    $broker = e($state ?: 'N/A');
                    $tradingId = filled($package->trading_id) ? $package->trading_id : 'N/A';
                    $tradingPassword = filled($package->trading_password) ? $package->trading_password : 'N/A';
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
                        . '<div style="font-size:12px;color:#374151;">Password: <span style="font-family:ui-monospace,SFMono-Regular,Menlo,Monaco,Consolas,monospace;">' . e($tradingPassword) . '</span></div>'
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
                    'active'         => 'Active',
                    'active_waiting' => 'Active Waiting',
                    'pending'        => 'Pending Verify',
                    'registered'     => 'Register',
                    'banned'         => 'Banned',
                ])
                ->label('Status')
                ->query(function (Builder $query, array $data): Builder {
                    $status = (string) ($data['value'] ?? '');

                    if ($status === '') {
                        return $query;
                    }

                    // Register / Banned come purely from account_status
                    if (in_array($status, ['registered', 'banned'], true)) {
                        return $query->where('account_status', $status);
                    }

                    // Package-derived statuses only apply to Active account holders
                    $query->where('account_status', 'active');

                    if ($status === 'active') {
                        return $query->whereHas(
                            'userPackages',
                            fn (Builder $q): Builder => $q->where('status', 'active')
                        );
                    }

                    if ($status === 'active_waiting') {
                        return $query
                            ->whereHas('userPackages', fn (Builder $q): Builder => $q->where('status', 'active_waiting'))
                            ->whereDoesntHave('userPackages', fn (Builder $q): Builder => $q->where('status', 'active'));
                    }

                    if ($status === 'pending') {
                        return $query
                            ->whereHas('userPackages', fn (Builder $q): Builder => $q->where('status', 'pending'))
                            ->whereDoesntHave('userPackages', fn (Builder $q): Builder => $q->whereIn('status', ['active', 'active_waiting']));
                    }

                    return $query;
                }),
        ])
        ->recordActions([
            Action::make('editPackageDetails')
                ->label(fn (?User $record): string => ($record && $record->userPackages()->exists()) ? 'Edit Package' : 'Add Package')
                ->icon('heroicon-o-credit-card')
                ->color('info')
                ->button()
                ->size('sm')
                ->extraAttributes(['class' => 'w-full justify-center'])
                ->visible(fn (?User $record): bool => $record !== null && ! in_array((string) $record->account_status, ['registered', 'banned'], true))
                ->slideOver()
                ->modalHeading(fn (?User $record): string => ($record && $record->userPackages()->exists()) ? 'Edit Package Details' : 'Add Package Details')
                ->fillForm(function (?User $record): array {
                    if (! $record) {
                        return [];
                    }

                    $pkg = $record->userPackages()->latest('id')->first();
                    if (! $pkg) {
                        return [];
                    }
                    return [
                        'package_id'       => $pkg->package_id,
                        'starts_at'        => $pkg->starts_at,
                        'status'           => $pkg->status,
                        'broker_name'      => $pkg->broker_name,
                        'trading_id'       => $pkg->trading_id,
                        'trading_password' => $pkg->trading_password,
                        'trading_server'   => $pkg->trading_server,
                        'equity'           => $pkg->equity,
                    ];
                })
                ->form([
                    Section::make('Subscription')
                        ->icon('heroicon-o-rectangle-stack')
                        ->schema([
                            Select::make('package_id')
                                ->options(fn (): array => Package::query()->orderBy('name')->pluck('name', 'id')->all())
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
                        ]),
                    Section::make('Package Status')
                        ->icon('heroicon-o-signal')
                        ->description('Package lifecycle state only. This does not control account access status.')
                        ->schema([
                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'active'         => 'Active',
                                    'active_waiting' => 'Active Waiting',
                                    'expired'        => 'Expired',
                                    'pending'        => 'Pending',
                                ])
                                ->required()
                                ->columnSpanFull(),
                        ]),
                    Section::make('Trading Credentials')
                        ->icon('heroicon-o-key')
                        ->columns(2)
                        ->schema([
                            TextInput::make('broker_name')->label('Broker name')->maxLength(255),
                            TextInput::make('trading_id')->label('MT4/MT5 ID')->maxLength(255),
                            TextInput::make('trading_password')
                                ->label('MT4/MT5 Password')
                                ->maxLength(255),
                            TextInput::make('trading_server')->label('Server')->maxLength(255),
                            TextInput::make('equity')
                                ->label('Deposit Amount/Equity')
                                ->numeric()
                                ->prefix('$')
                                ->required()
                                ->minValue(fn (Get $get): float => (float) (Package::query()->whereKey($get('package_id'))->value('price') ?? 0))
                                ->helperText(fn (Get $get): string => 'Must be at least the selected package minimum deposit: $' . number_format((float) (Package::query()->whereKey($get('package_id'))->value('price') ?? 0), 2))
                                ->columnSpanFull(),
                        ]),
                ])
                ->action(function (?User $record, array $data): void {
                    if (! $record) {
                        return;
                    }

                    $pkg = $record->userPackages()->latest('id')->first();
                    if ($pkg) {
                        $pkg->update($data);
                        return;
                    }
                    $record->userPackages()->create($data);
                }),
            EditAction::make()
                ->label('Edit Customer')
                ->icon('heroicon-o-pencil-square')
                ->color('primary')
                ->button()
                ->size('sm')
                ->extraAttributes(['class' => 'w-full justify-center']),
            \Filament\Actions\DeleteAction::make()
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->button()
                ->size('sm')
                ->extraAttributes(['class' => 'w-full justify-center']),
        ])
        ->actionsColumnLabel('Actions')
        ->recordActionsAlignment('users-actions-vertical')
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
