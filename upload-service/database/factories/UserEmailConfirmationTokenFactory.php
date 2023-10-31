<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserEmailConfirmationTokenFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'token' => Str::uuid()->toString(),
            'expires_in' => now()->addDay()
        ];
    }
}
