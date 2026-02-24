<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AffiliateResource\Pages;
use App\Models\Affiliate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
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
        return $schema->components([
            Select::make('user_id')->relationship('user', 'name')->searchable()->required()->disabled(),
            TextInput::make('referral_code')->required()->disabled(),
            TextInput::make('commission_rate')
                ->numeric()
                ->suffix('%')
                ->minValue(0)
                ->maxValue(100)
                ->required(),
            TextInput::make('total_referrals')
                ->numeric()
                ->disabled(),
            TextInput::make('total_commissions')
                ->numeric()
                ->disabled(),
            Select::make('approval_status')
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
                }),
            DatePicker::make('approved_at'),
            DatePicker::make('rejected_at'),
            Textarea::make('rejection_reason')
                ->maxLength(500),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('User')->searchable(),
            TextColumn::make('user.email')->label('Email')->searchable(),
            TextColumn::make('referral_code')->searchable(),
            TextColumn::make('commission_rate')->suffix('%'),
            TextColumn::make('total_referrals')->label('Referrals'),
            TextColumn::make('total_commissions')->money('usd'),
            BadgeColumn::make('approval_status')
                ->getStateUsing(function ($record) {
                    if ($record->isPending()) return 'pending';
                    if ($record->isApproved()) return 'approved';
                    if ($record->isRejected()) return 'rejected';
                })
                ->colors([
                    'warning' => 'pending',
                    'success' => 'approved',
                    'danger' => 'rejected',
                ]),
            TextColumn::make('approved_at')->date()->sortable(),
        ])->filters([
            SelectFilter::make('approval_status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->label('Status'),
        ])->recordActions([
            \Filament\Actions\EditAction::make(),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAffiliates::route('/'),
            'edit' => Pages\EditAffiliate::route('/{record}/edit'),
        ];
    }
}
