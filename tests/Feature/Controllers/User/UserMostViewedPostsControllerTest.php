<?php

namespace Tests\Feature\Controller\User;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserMostViewedPostsControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Redis::flushDB();
    }

    #[Test]
    public function shouldReturnAllUserSortByPostViewCount(): void
    {
        $firstPost = Post::factory()->create([
            'view_count' => 8,
        ]);
        $secondPost = Post::factory()->create([
            'view_count' => 5,
        ]);
        $thirdPost = Post::factory()->create([
            'view_count' => 10,
        ]);

        $response = $this->getJson(route('users.most-viewed-posts'));

        $response->assertOk()
            ->assertJsonStructure([
                'data' => [
                    'results',
                ],
                'server_time',
            ])
            ->assertJson([
                'data' => [
                    'results' => [
                        [
                            'id' => $thirdPost->user->id,
                            'mobile' => $thirdPost->user->mobile,
                            'total_post_views' => 10,
                            'profile_image' => null,
                        ],
                        [
                            'id' => $firstPost->user->id,
                            'mobile' => $firstPost->user->mobile,
                            'total_post_views' => 8,
                            'profile_image' => null,
                        ],
                        [
                            'id' => $secondPost->user->id,
                            'mobile' => $secondPost->user->mobile,
                            'total_post_views' => 5,
                            'profile_image' => null,
                        ],
                    ],
                    'error_message' => '',
                ],
                'server_time' => Carbon::now()->toIso8601String(),
            ]);
    }
}
