<?php

use Illuminate\Mail\Events\MessageSent;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Event;
use Syropian\LaravelNotificationChannelThrottling\Tests\Support\Models\User;
use Syropian\LaravelNotificationChannelThrottling\Tests\Support\Notifications\NonThrottledNotification;
use Syropian\LaravelNotificationChannelThrottling\Tests\Support\Notifications\TestNotification;

beforeEach(function () {
    $this->user = User::factory()->create();
});

afterEach(function () {
    $this->travelBack();
});

it('throttles notification channels', function () {
    Event::fake([
        MessageSent::class,
    ]);

    $this->user->notify(new TestNotification());
    $this->user->notify(new TestNotification());

    Event::assertDispatched(MessageSent::class, 1);
    expect(DatabaseNotification::count())->toBe(2);

    $this->travel(15)->minutes();

    $this->user->notify(new TestNotification());

    Event::assertDispatched(MessageSent::class, 2);
    expect(DatabaseNotification::count())->toBe(3);
});

it('ignores notifications that do not implement the ThrottlesChannels contract', function () {
    Event::fake([
        MessageSent::class,
    ]);

    $this->user->notify(new NonThrottledNotification());
    $this->user->notify(new NonThrottledNotification());

    Event::assertDispatched(MessageSent::class, 2);
    expect(DatabaseNotification::count())->toBe(2);
});
