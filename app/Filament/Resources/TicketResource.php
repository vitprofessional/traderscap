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
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Placeholder;
use Filament\Actions\Action as FilamentAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
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
        return $schema->components([
            TextInput::make('subject')->required()->maxLength(191),
            Textarea::make('description'),
            FileUpload::make('attachment')
                ->disk('public')
                ->directory('ticket_attachments')
                ->visibility('public')
                ->preserveFilenames()
                ->label('Attachment')
                ->helperText('Optional attachment for this ticket'),
            // Inline admin chat removed from edit form to avoid Livewire multiple-root errors.
            // Use the dedicated Reply page instead: /admin/tickets/reply?ticket={id}
            Select::make('status')
                ->label('Status')
                ->options([
                    'open' => 'Open',
                    'resolved' => 'Resolved',
                ])
                ->default('open')
                ->required(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id')->label('Ticket #'),
            TextColumn::make('subject')->limit(40),
            TextColumn::make('attachment')
                ->label('Attachment')
                ->limit(30)
                ->url(fn ($state) => $state ? \Illuminate\Support\Facades\Storage::disk('public')->url($state) : null),
            TextColumn::make('status')->sortable(),
            TextColumn::make('priority')->sortable(),
            TextColumn::make('created_at')->dateTime(),
            ])->filters([])
            ->actions([
                EditAction::make(),
                FilamentAction::make('reply')
                    ->label('Reply')
                    ->url(fn (Ticket $record): string => url(config('filament.path', 'admin') . '/tickets/reply?ticket=' . $record->id)),
                FilamentAction::make('mark_resolved')
                    ->label('Mark Resolved')
                    ->action(fn (Ticket $record) => $record->update(['status' => 'resolved']))
                    ->visible(fn (Ticket $record) => $record->status !== 'resolved'),
                DeleteAction::make(),
            ]);
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
