# Throttles notifications on a per-channel basis

[![Latest Version on Packagist](https://img.shields.io/packagist/v/syropian/laravel-notification-channel-throttling.svg?style=flat-square)](https://packagist.org/packages/syropian/laravel-notification-channel-throttling)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/syropian/laravel-notification-channel-throttling/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/syropian/laravel-notification-channel-throttling/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/syropian/laravel-notification-channel-throttling/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/syropian/laravel-notification-channel-throttling/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/syropian/laravel-notification-channel-throttling.svg?style=flat-square)](https://packagist.org/packages/syropian/laravel-notification-channel-throttling)

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
public function throttleChannels(object $notifiable, array $channels): array
{
    return [
        'mail' => [
            'key' => $notifiable->id,
            'maxAttempts' => 1,
            'decaySeconds' => 900, // 15 minutes
        ],
        'database' => false,
    ];
}
```

> [!NOTE]
> The `key` property is optional, and allows you to scope your channel throttles however you wish.

3. That's it!

## Testing

```bash
composer test
```

## Credits

-   [Collin Henderson](https://github.com/syropian)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
