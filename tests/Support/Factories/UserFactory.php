<?php

namespace Syropian\LaravelNotificationChannelThrottling\Tests\Support\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Syropian\LaravelNotificationChannelThrottling\Tests\Support\Models\User;

class UserFactory extends Factory
{
    public $model = User::class;

    public function definition(): array
    {
        return [
            'email' => fake()->unique()->safeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
