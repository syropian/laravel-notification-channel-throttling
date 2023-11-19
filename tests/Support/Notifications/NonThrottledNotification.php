<?php

namespace Syropian\LaravelNotificationChannelThrottling\Tests\Support\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NonThrottledNotification extends Notification
{
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    // We're implementing this method just to prove it gets ignored if the notification does not implement ThrottlesChannels
    public function throttleChannels(object $notifiable, array $channels): array
    {
        return [
            'mail' => [
                'key' => $notifiable->id,
                'maxAttempts' => 1,
                'decaySeconds' => 900,
            ],
            'database' => false,
        ];
    }

    public function toMail(): MailMessage
    {
        return (new MailMessage)->line('This is a test notification');
    }

    public function toArray($notifiable)
    {
        return [];
    }
}
