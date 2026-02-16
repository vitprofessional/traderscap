<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class AdminTicketChat extends Component
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

        $attachmentPath = null;
        if ($this->attachment) {
            try {
                if (is_string($this->attachment)) {
                    $attachmentPath = $this->attachment;
                } else {
                    $attachmentPath = $this->attachment->store('ticket_attachments', 'public');
                }
            } catch (\Throwable $e) {
                logger()->error('AdminTicketChat: failed storing attachment: '.$e->getMessage(), ['ticket_id' => $this->ticket->id]);
                $attachmentPath = null;
                $this->addError('attachment', 'Failed to upload attachment.');
            }
        }

        $message = TicketMessage::create([
            'ticket_id' => $this->ticket->id,
            'user_id' => null,
            'message' => $this->message ?: null,
            'is_admin' => true,
            'attachment' => $attachmentPath,
        ]);

        $this->ticket->status = 'open';
        $this->ticket->save();

        // notify ticket owner
        try {
            if ($this->ticket->user) {
                $this->ticket->user->notify(new \App\Notifications\NewTicketReply($message));
            }
        } catch (\Throwable $e) {
            logger()->error('AdminTicketChat: notify failed: '.$e->getMessage(), ['ticket_id' => $this->ticket->id]);
        }

        $this->message = '';
        $this->attachment = null;

        $this->ticket->load('messages.user');
    }

    public function render()
    {
        $this->ticket->load(['messages' => function ($q) { $q->orderBy('created_at'); }, 'messages.user']);

        return view('livewire.admin-ticket-chat', [
            'messages' => $this->ticket->messages,
        ]);
    }
}
