<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\URL;

class PendingEmailVerification extends Notification
{
    use Queueable;

    public function __construct(
        private readonly string $pendingEmail,
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $verifyUrl = URL::temporarySignedRoute(
            'verification.email-change.verify',
            now()->addHours(24),
            [
                'id'   => $notifiable->getKey(),
                'hash' => sha1($this->pendingEmail),
            ]
        );

        return (new MailMessage)
            ->subject('Confirm Your New Email Address')
            ->greeting('Hello, ' . $notifiable->name . '!')
            ->line('We received a request to change your email address to:')
            ->line('**' . $this->pendingEmail . '**')
            ->action('Confirm New Email', $verifyUrl)
            ->line('This link will expire in 24 hours.')
            ->line('If you did not request this change, you can safely ignore this email. Your current email address will remain unchanged.');
    }
}
