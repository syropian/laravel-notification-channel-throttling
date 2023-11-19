<?php

namespace Syropian\LaravelNotificationChannelThrottling\Tests\Support\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as BaseUser;
use Illuminate\Notifications\Notifiable;

class User extends BaseUser
{
    use HasFactory;
    use Notifiable;
}
