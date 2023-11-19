<?php

namespace Syropian\LaravelNotificationChannelThrottling\Contracts;

interface ThrottlesChannels
{
    public function throttleChannels(object $notifiable, array $channels): array;
}
