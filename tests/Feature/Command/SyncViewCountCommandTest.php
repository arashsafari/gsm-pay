<?php

namespace Tests\Feature\Command;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Redis;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SyncViewCountCommandTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Redis::flushDB();
    }

    #[Test]
    public function shouldDoNotSyncViewCount(): void
    {
        $posts = Post::factory()->count(3)->create([
            'view_count' => 2,
        ]);

        $this->artisan('app:sync-view-count-command')->assertSuccessful();

        foreach ($posts as $post) {
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'view_count' => 2
            ]);
        }

        foreach ($posts as $post) {
            $this->assertEquals(null, Redis::get("post:$post->id:views"));
        }
    }

    #[Test]
    public function shouldSyncViewCount(): void
    {
        $posts = Post::factory()->count(3)->create([
            'view_count' => 3
        ]);

        foreach ($posts as $post) {
            Redis::incr("post:$post->id:views");
            Redis::incr("post:$post->id:views");

        }

        $this->artisan('app:sync-view-count-command')->assertSuccessful();

        foreach ($posts as $post) {
            $this->assertDatabaseHas('posts', [
                'id' => $post->id,
                'view_count' => 5
            ]);
        }

        foreach ($posts as $post) {
            $this->assertEquals(null, Redis::get("post:$post->id:views"));
        }
    }
}
