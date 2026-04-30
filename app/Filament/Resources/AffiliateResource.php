<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliateResource\Pages;
use App\Models\Affiliate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Icons\Heroicon;

class AffiliateResource extends Resource
{
    protected static ?string $model = Affiliate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;
    protected static \UnitEnum|string|null $navigationGroup = 'Users';
    protected static ?string $navigationLabel = 'Affiliates';
    protected static ?int $navigationSort = 7;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Affiliate details')
                    ->icon('heroicon-o-user-group')
                    ->description('Account information and referral statistics for this affiliate.')
                    ->schema([
                        Select::make('user_id')
                            ->relationship('user', 'name')
                            ->label('Linked user')
                            ->searchable()
                            ->required()
                            ->disabled()
                            ->helperText('The customer account linked to this affiliate.')
                            ->columnSpanFull(),
                        TextInput::make('referral_code')
                            ->label('Referral code')
                            ->required()
                            ->disabled()
                            ->helperText('Auto-generated. Cannot be changed.')
                            ->columnSpanFull(),
                        TextInput::make('total_referrals')
                            ->label('Total referrals')
                            ->numeric()
                            ->disabled()
                            ->columnSpanFull(),
                        TextInput::make('total_commissions')
                            ->label('Total commissions earned')
                            ->numeric()
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Commission & approval')
                    ->icon('heroicon-o-banknotes')
                    ->description('Rate and approval status for this affiliate.')
                    ->schema([
                        TextInput::make('commission_rate')
                            ->label('Commission rate')
                            ->numeric()
                            ->suffix('%')
                            ->minValue(0)
                            ->maxValue(100)
                            ->required()
                            ->helperText('Percentage of each referred sale paid to this affiliate.')
                            ->columnSpanFull(),
                        Select::make('approval_status')
                            ->label('Approval status')
                            ->options([
                                'pending' => 'Pending Review',
                                'approved' => 'Approved',
                                'rejected' => 'Rejected',
                            ])
                            ->live()
                            ->required()
                            ->default('pending')
                            ->afterStateUpdated(function (callable $get, callable $set) {
                                $status = $get('approval_status');
                                if ($status === 'approved') {
                                    $set('approved_at', now());
                                    $set('rejected_at', null);
                                    $set('rejection_reason', null);
                                    $set('is_active', true);
                                } elseif ($status === 'rejected') {
                                    $set('rejected_at', now());
                                    $set('approved_at', null);
                                    $set('is_active', false);
                                } else {
                                    $set('approved_at', null);
                                    $set('rejected_at', null);
                                    $set('is_active', false);
                                }
                            })
                            ->columnSpanFull(),
                        DatePicker::make('approved_at')
                            ->label('Approved on')
                            ->columnSpanFull(),
                        DatePicker::make('rejected_at')
                            ->label('Rejected on')
                            ->columnSpanFull(),
                        Textarea::make('rejection_reason')
                            ->label('Rejection reason')
                            ->helperText('Shown internally; not sent to the affiliate.')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')
                ->label('Affiliate')
                ->searchable()
                ->weight('medium')
                ->description(fn ($record) => $record->user?->email),
            TextColumn::make('referral_code')
                ->label('Referral code')
                ->badge()
                ->color('gray')
                ->searchable(),
            TextColumn::make('commission_rate')
                ->label('Commission')
                ->suffix('%')
                ->sortable(),
            TextColumn::make('total_referrals')
                ->label('Referrals')
                ->badge()
                ->color('info')
                ->alignCenter(),
            TextColumn::make('total_commissions')
                ->label('Earned')
                ->money('usd')
                ->sortable(),
            TextColumn::make('approval_status')
                ->label('Status')
                ->badge()
                ->color(fn ($state): string => match ($state) {
                    'approved' => 'success',
                    'rejected' => 'danger',
                    'pending' => 'warning',
                    default => 'gray',
                })
                ->formatStateUsing(fn ($state): string => match ($state) {
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                    default => ucfirst($state),
                }),
            TextColumn::make('approved_at')
                ->label('Approved')
                ->date('M d, Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])->filters([
            SelectFilter::make('approval_status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ]),
        ])->defaultSort('approved_at', 'desc')
        ->recordActions([
            \Filament\Actions\EditAction::make(),
        ])
        ->emptyStateHeading('No affiliates yet')
        ->emptyStateDescription('Affiliates appear here after customers apply through the website.')
        ->emptyStateIcon('heroicon-o-user-group');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAffiliates::route('/'),
            'edit' => Pages\EditAffiliate::route('/{record}/edit'),
        ];
    }
}
