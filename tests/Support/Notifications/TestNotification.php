<?php

namespace Syropian\LaravelNotificationChannelThrottling\Tests\Support\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Syropian\LaravelNotificationChannelThrottling\Contracts\ThrottlesChannels;

class TestNotification extends Notification implements ThrottlesChannels
{
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

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
