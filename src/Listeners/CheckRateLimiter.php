<?php

namespace Syropian\LaravelNotificationChannelThrottling\Listeners;

use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Support\Facades\RateLimiter;
use Syropian\LaravelNotificationChannelThrottling\Contracts\ThrottlesChannels;

class CheckRateLimiter
{
    public function handle(NotificationSending $event): bool
    {
        if ($event->notification instanceof ThrottlesChannels) {
            $channels = $event->notification->via($event->notifiable);
            $throttleConfig = $event->notification->throttleChannels($event->notifiable, $channels);
            $channelConfig = $throttleConfig[$event->channel];

            if (empty($channelConfig)) {
                return true;
            }

            $key = $event->notification::class.':'.$event->channel;

            if (! empty($channelConfig['key'])) {
                $key .= (string) $channelConfig['key'];
            }

            $maxAttempts = $channelConfig['maxAttempts'] ?? 1;

            return ! RateLimiter::tooManyAttempts($key, $maxAttempts);
        }

        return true;
    }
}
