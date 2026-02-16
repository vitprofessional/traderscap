<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\TicketMessage;

class NewTicketReply extends Notification implements ShouldQueue
{
    use Queueable;

    protected TicketMessage $messageRecord;

    public function __construct(TicketMessage $messageRecord)
    {
        $this->messageRecord = $messageRecord;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $ticket = $this->messageRecord->ticket;

        return (new MailMessage)
                    ->subject('Reply on your support ticket #'.$ticket->id)
                    ->greeting('Hello '.($notifiable->name ?? ''))
                    ->line('There is a new reply from our support team on your ticket: "'.$ticket->subject.'"')
                    ->line($this->messageRecord->message ?? '')
                    ->action('View Ticket', url(route('complaints.show', $ticket)))
                    ->line('Thank you for using our support.');
    }

    public function toArray($notifiable)
    {
        return [
            'ticket_id' => $this->messageRecord->ticket_id,
            'message_id' => $this->messageRecord->id,
            'message' => $this->messageRecord->message,
            'attachment' => $this->messageRecord->attachment ?? null,
        ];
    }
}
