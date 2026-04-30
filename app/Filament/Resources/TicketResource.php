<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\Action as FilamentAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Resources\TicketResource\RelationManagers\TicketMessagesRelationManager;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;
    protected static \UnitEnum|string|null $navigationGroup = 'Support';
    protected static ?string $navigationLabel = 'Complaints';
    protected static ?int $navigationSort = 20;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(['default' => 1, 'lg' => 3])
            ->components([
                Section::make('Ticket details')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->description('The subject, description, and any attachment submitted with this ticket.')
                    ->schema([
                        TextInput::make('subject')
                            ->label('Subject')
                            ->required()
                            ->maxLength(191)
                            ->columnSpanFull(),
                        Textarea::make('description')
                            ->label('Description')
                            ->helperText('Full details provided by the customer.')
                            ->rows(5)
                            ->columnSpanFull(),
                        FileUpload::make('attachment')
                            ->disk('public')
                            ->directory('ticket_attachments')
                            ->visibility('public')
                            ->preserveFilenames()
                            ->label('Attachment')
                            ->helperText('Optional file attached to this ticket.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 2]),
                Section::make('Status')
                    ->icon('heroicon-o-tag')
                    ->description('Current resolution state of this ticket.')
                    ->schema([
                        Select::make('status')
                            ->label('Status')
                            ->options([
                                'open' => 'Open',
                                'resolved' => 'Resolved',
                            ])
                            ->default('open')
                            ->required()
                            ->helperText('Set to Resolved once the customer\'s issue is addressed.')
                            ->columnSpanFull(),
                    ])
                    ->columnSpan(['default' => 1, 'lg' => 1]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')
                ->label('Ticket #')
                ->sortable()
                ->width(80),
            TextColumn::make('subject')
                ->label('Subject')
                ->searchable()
                ->limit(50)
                ->weight('medium')
                ->description(fn ($record) => $record->user?->name),
            TextColumn::make('status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'open' => 'warning',
                    'resolved' => 'success',
                    default => 'gray',
                })
                ->sortable(),
            TextColumn::make('priority')
                ->badge()
                ->color(fn ($state): string => match ($state) {
                    'high' => 'danger',
                    'medium' => 'warning',
                    'low' => 'gray',
                    default => 'gray',
                })
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('created_at')
                ->label('Opened')
                ->dateTime('M d, Y')
                ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'open' => 'Open',
                        'resolved' => 'Resolved',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                FilamentAction::make('reply')
                    ->label('Reply')
                    ->icon('heroicon-m-chat-bubble-left')
                    ->url(fn (Ticket $record): string => url(config('filament.path', 'admin') . '/tickets/reply?ticket=' . $record->id)),
                FilamentAction::make('mark_resolved')
                    ->label('Resolve')
                    ->icon('heroicon-m-check')
                    ->color('success')
                    ->action(fn (Ticket $record) => $record->update(['status' => 'resolved']))
                    ->visible(fn (Ticket $record) => $record->status !== 'resolved'),
                DeleteAction::make(),
            ])
            ->emptyStateHeading('No tickets yet')
            ->emptyStateDescription('Support tickets submitted by customers will appear here.')
            ->emptyStateIcon('heroicon-o-chat-bubble-left-right');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        try {
            return (string) Ticket::where('status', 'open')->count();
        } catch (\Throwable $e) {
            return null;
        }
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function getRelations(): array
    {
        return [
            TicketMessagesRelationManager::class,
        ];
    }
}
