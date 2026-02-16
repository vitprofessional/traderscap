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
use Filament\Forms\Components\Placeholder;
use Filament\Actions\Action as FilamentAction;
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
            Placeholder::make('admin_inline_chat')
                ->content(fn (callable $get) => view('filament.partials.admin-ticket-chat', ['ticket_id' => $get('id')]))
                ->visible(fn (callable $get) => (bool) $get('id')),
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
                FilamentAction::make('reply')
                    ->label('Reply')
                    ->form([
                        Textarea::make('message')->label('Message')->required(),
                        FileUpload::make('attachment')
                            ->disk('public')
                            ->directory('ticket_attachments')
                            ->visibility('public')
                            ->preserveFilenames(),
                    ])
                    ->action(function (Ticket $record, array $data) {
                        $adminId = auth()->id();
                        $msg = \App\Models\TicketMessage::create([
                            'ticket_id' => $record->id,
                            'user_id' => null,
                            'message' => $data['message'] ?? null,
                            'is_admin' => true,
                            'attachment' => $data['attachment'] ?? null,
                        ]);

                        $record->status = 'open';
                        $record->save();

                        if ($record->user) {
                            try {
                                $record->user->notify(new \App\Notifications\NewTicketReply($msg));
                            } catch (\Throwable $e) {
                                logger()->error('Failed to notify user about admin reply: '.$e->getMessage());
                            }
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Reply sent')
                            ->success()
                            ->send();
                    }),
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
