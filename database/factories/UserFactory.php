<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition(): array
    {
        $password = fake()->numerify('091########');
        return [
            'mobile' => $password,
            'password' => Hash::make($password),
        ];
    }
}
