<div align="center">
    <img src="/art/github_header.png" alt="Laravel Notification Channel Throttling">
    <h1>🚦 Laravel Notification Channel Throttling</h1>
    <p>Throttle your Laravel notifications on a per-channel basis</p>
</div>

<p align="center">
    <a href="https://packagist.org/packages/syropian/laravel-notification-channel-throttling"><img src="https://img.shields.io/packagist/v/syropian/laravel-notification-channel-throttling.svg?style=flat-square" alt="Latest Version on Packagist"></a>
    <a href="https://github.com/syropian/laravel-notification-channel-throttling/actions?query=workflow%3Arun-tests+branch%3Amain"><img src="https://img.shields.io/github/actions/workflow/status/syropian/laravel-notification-channel-throttling/run-tests.yml?branch=main&label=tests&style=flat-square" alt="GitHub Tests Action Status"></a>
    <a href="https://github.com/syropian/laravel-notification-channel-throttling/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain"><img src="https://img.shields.io/github/actions/workflow/status/syropian/laravel-notification-channel-throttling/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square" alt="GitHub Code Style Action Status"></a>
    <a href="https://packagist.org/packages/syropian/laravel-notification-channel-throttling"><img src="https://img.shields.io/packagist/dt/syropian/laravel-notification-channel-throttling.svg?style=flat-square" alt="Total Downloads"></a>
</p>

## Introduction

When sending notifications through multiple channels (say email and SMS), you may want to throttle the number of notifications sent through a specific channel. For example, you could limit the number of SMS notifications sent to a user to 1 per day, and limit emails to 5 per day. This package allows you to configure this easily directly in your notification classes.

## Installation

You can install the package via composer:

```bash
composer require syropian/laravel-notification-channel-throttling
```

## Usage

1. Ensure the notification you want to throttle implements `Syropian\LaravelNotificationChannelThrottling\Contracts\ThrottlesChannels`.
2. Implement the `throttleChannels` method. This method should return an array of channels to throttle, and the configuration for each channel. To omit a channel from throttling either omit the channel from the array, or set the value to `false`.

```php
use Illuminate\Notifications\Notification;
use Syropian\LaravelNotificationChannelThrottling\Contracts\ThrottlesChannels;

class ExampleNotification extends Notification implements ThrottlesChannels {
    // ...

    public function throttleChannels(object $notifiable, array $channels): array
    {
        /**
         * Throttle the mail channel, so that only one
         * email notification is sent every 15 minutes
         */
        return [
            'mail' => [
                'maxAttempts' => 1,
                'decaySeconds' => 900,
            ],
            'database' => false,
        ];
    }
}
```

## Scoping the rate limiter

By default, the [rate limiter](https://laravel.com/docs/rate-limiting) instance used to throttle is automatically scoped to the notification and channel. If you would like to further scope the rate limiter, you may pass a `key` to the channel configuration.

```php
public function __construct(public Post $post) {}

public function throttleChannels(object $notifiable, array $channels): array
{
    return [
        'mail' => [
            'key' => $notifiable->id . ':' . $this->post->id,
            'maxAttempts' => 1,
            'decaySeconds' => 900,
        ],
        'database' => false,
    ];
}
```

In this example we're rate limiting the mail channel, and we're scoping it to a specific combination of a user and a post.

## Testing

```bash
composer test
```

## Credits

-   [Collin Henderson](https://github.com/syropian)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
