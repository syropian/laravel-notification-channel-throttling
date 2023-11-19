<?php

namespace Syropian\LaravelNotificationChannelThrottling;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Syropian\LaravelNotificationChannelThrottling\Providers\EventServiceProvider;

class LaravelNotificationChannelThrottlingServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package->name('laravel-notification-channel-throttling');
    }

    public function registeringPackage()
    {
        $this->app->register(EventServiceProvider::class);
    }
}
