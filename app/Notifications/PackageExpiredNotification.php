<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\UserPackage;

class PackageExpiredNotification extends Notification
{
    use Queueable;

    public UserPackage $userPackage;

    public function __construct(UserPackage $userPackage)
    {
        $this->userPackage = $userPackage;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $packageName = $this->userPackage->package->name ?? 'your package';

        return (new MailMessage)
            ->subject('Your package has expired')
            ->greeting('Hello ' . ($notifiable->name ?? ''))
            ->line("The package \"{$packageName}\" has expired on " . ($this->userPackage->ends_at?->toDateString() ?? 'N/A') . ".")
            ->line('If you wish to renew or purchase a new package, please visit your account or contact support.')
            ->salutation('Regards,')
            ->salutation(config('app.name'));
    }
}
