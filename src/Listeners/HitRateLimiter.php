<?php

namespace Syropian\LaravelNotificationChannelThrottling\Listeners;

use Illuminate\Notifications\Events\NotificationSent;
use Illuminate\Support\Facades\RateLimiter;
use Syropian\LaravelNotificationChannelThrottling\Contracts\ThrottlesChannels;

class HitRateLimiter
{
    public function handle(NotificationSent $event)
    {
        if ($event->notification instanceof ThrottlesChannels) {
            $channels = $event->notification->via($event->notifiable);
            $throttleConfig = $event->notification->throttleChannels($event->notifiable, $channels);
            $channelConfig = $throttleConfig[$event->channel];

            if (empty($channelConfig)) {
                return;
            }

            $key = $event->notification::class.':'.$event->channel;

            if (! empty($channelConfig['key'])) {
                $key .= (string) $channelConfig['key'];
            }

            $decaySeconds = $channelConfig['decaySeconds'] ?? 1;

            RateLimiter::hit($key, $decaySeconds);
        }
    }
}
