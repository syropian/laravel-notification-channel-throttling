<?php

namespace Syropian\LaravelNotificationChannelThrottling\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Notifications\Events\NotificationSending;
use Illuminate\Notifications\Events\NotificationSent;
use Syropian\LaravelNotificationChannelThrottling\Listeners\CheckRateLimiter;
use Syropian\LaravelNotificationChannelThrottling\Listeners\HitRateLimiter;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        NotificationSending::class => [
            CheckRateLimiter::class,
        ],
        NotificationSent::class => [
            HitRateLimiter::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
