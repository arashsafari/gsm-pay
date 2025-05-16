<?php

namespace Tests\Feature\Post;

use App\Models\Post;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function shouldReturnAllPostWithPagination(): void
    {
        Post::factory()->count(10)->create();

        $response = $this->getJson(route('posts.index'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'results',
                    'links',
                    'meta',
                    'error_message',
                ],
                'server_time',
            ]);
    }

    #[Test]
    public function shouldReturnPostDetailsWhenViewCountIncrease(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->forUser($user)->create();

        $response = $this->getJson(route('posts.show', $post->id));

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'results' => [
                        'title' => $post->title,
                        'body' => $post->body,
                        'view_count' => 1,
                        'user' => [
                            'id' => $user->id,
                            'mobile' => $user->mobile,
                        ],
                    ],
                    'error_message' => '',
                ],
                'server_time' => Carbon::now()->toIso8601String()
            ]);
    }

    #[Test]
    public function shouldReturnPostDetailsWhenViewCountDoNotIncrease(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->forUser($user)->create([
            'view_count' => 1,
        ]);

        $cacheKey = sprintf(
            '%s_view_count_%d_%s',
            $post->getMorphClass(),
            $post->getKey(),
            request()->ip()
        );
        Cache::set($cacheKey, true);

        $response = $this->getJson(route('posts.show', $post->id));

        $response->assertOk()
            ->assertJson([
                'data' => [
                    'results' => [
                        'title' => $post->title,
                        'body' => $post->body,
                        'view_count' => 1,
                        'user' => [
                            'id' => $user->id,
                            'mobile' => $user->mobile,
                        ],
                    ],
                    'error_message' => '',
                ],
                'server_time' => Carbon::now()->toIso8601String()
            ]);
    }

    #[Test]
    public function shouldReturnErrorWhenPostNotFound(): void
    {
        $response = $this->getJson(route('posts.show', 15));

        $response->assertNotFound()
            ->assertJson([
                'data' => [
                    'results' => [],
                    'error_message' => 'No query results for model [App\Models\Post] 15',
                ],
                'server_time' => Carbon::now()->toIso8601String()
            ]);
    }
}
