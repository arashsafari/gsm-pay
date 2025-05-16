<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(),
            'body' => $this->faker->paragraph(),
            'user_id' => User::factory(),
        ];
    }

    public function forUser(User $user): static
    {
        return $this->state(fn(array $attr): array => [
            'user_id' => $user->id,
        ]);
    }

}
