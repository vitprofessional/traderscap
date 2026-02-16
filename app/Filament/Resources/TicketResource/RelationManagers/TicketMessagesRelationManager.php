<?php

namespace App\Filament\Resources\TicketResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\CreateAction;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use App\Models\TicketMessage;

class TicketMessagesRelationManager extends RelationManager
{
    protected static string $relationship = 'messages';

    protected static ?string $recordTitleAttribute = 'message';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Textarea::make('message')
                ->label('Reply')
                ->required()
                ->columnSpanFull(),
            FileUpload::make('attachment')
                ->label('Attachment')
                ->disk('public')
                ->directory('storage/app/public/ticket_attachments')
                ->visibility('public')
                ->preserveFilenames()
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('message')->limit(80)->label('Message'),
                TextColumn::make('attachment')
                    ->label('Attachment')
                    ->limit(30)
                    ->url(fn ($state) => $state ? \Illuminate\Support\Facades\Storage::disk('public')->url($state) : null),
                TextColumn::make('user.name')->label('User'),
                IconColumn::make('is_admin')->label('From Admin')->boolean()->trueColor('primary'),
                TextColumn::make('created_at')->dateTime()->label('Posted'),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()->label('Reply'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function handleRecordCreation(array $data): TicketMessage
    {
        // Filament's FileUpload stores the uploaded filename/path in $data['attachment'] when used.
        $adminId = auth()->id();

            $message = $this->getRelationship()->create([
                'ticket_id' => $this->ownerRecord->id,
                'user_id' => null,
                'message' => $data['message'] ?? null,
                'is_admin' => true,
                'attachment' => $data['attachment'] ?? null,
            ]);

        // mark the ticket as open so customer sees the admin reply
        $this->ownerRecord->status = 'open';
        $this->ownerRecord->save();

        // notify ticket owner (if exists)
        try {
            if ($this->ownerRecord->user) {
                $this->ownerRecord->user->notify(new \App\Notifications\NewTicketReply($message));
            }
        } catch (\Throwable $e) {
            // don't break admin flow on notification errors; log if needed
            logger()->error('Failed to send NewTicketReply notification: '.$e->getMessage());
        }

        return $message;
    }
}
