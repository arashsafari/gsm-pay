<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\User;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->count(10)
            ->has(Post::factory()->count(10))
            ->create();
    }
}
