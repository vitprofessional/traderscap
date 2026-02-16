<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class TicketChat extends Component
{
    use WithFileUploads;

    public Ticket $ticket;
    public $message = '';
    public $attachment;

    protected $rules = [
        'message' => 'nullable|string',
        'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,txt,doc,docx|max:5120',
    ];

    public function mount(Ticket $ticket)
    {
        $this->ticket = $ticket->load('messages.user');
    }

    public function sendMessage()
    {
        $this->validate();

        $user = Auth::user();

        $attachmentPath = null;
        if ($this->attachment) {
            try {
                if (is_string($this->attachment)) {
                    // sometimes Livewire can pass a string path instead of UploadedFile
                    $attachmentPath = $this->attachment;
                } else {
                    $attachmentPath = $this->attachment->store('ticket_attachments', 'public');
                }
                logger()->info('TicketChat: stored attachment', ['ticket_id' => $this->ticket->id, 'path' => $attachmentPath, 'user_id' => $user?->id]);
            } catch (\Throwable $e) {
                logger()->error('TicketChat: failed storing attachment: '.$e->getMessage(), ['ticket_id' => $this->ticket->id, 'user_id' => $user?->id]);
                $attachmentPath = null;
                $this->addError('attachment', 'Failed to upload attachment.');
            }
        }

        TicketMessage::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => $user ? $user->id : null,
            'message' => $this->message ?: null,
            'is_admin' => false,
            'attachment' => $attachmentPath,
        ]);

        $this->ticket->status = 'pending';
        $this->ticket->save();

        $this->message = '';
        $this->attachment = null;

        $this->ticket->load('messages.user');

        // No-op event emission here to maintain compatibility across Livewire versions.
        // The frontend uses Livewire's `message.processed` hook to auto-scroll after updates.
    }

    public function render()
    {
        // reload messages on each render (wire:poll will trigger renders)
        $this->ticket->load(['messages' => function ($q) {
            $q->orderBy('created_at');
        }, 'messages.user']);

        return view('livewire.ticket-chat', [
            'messages' => $this->ticket->messages,
        ]);
    }
}
