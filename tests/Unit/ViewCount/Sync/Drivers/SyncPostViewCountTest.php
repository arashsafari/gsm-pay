<?php

namespace Tests\Unit\ViewCount\Sync\Drivers;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\ViewCount\Sync\Drivers\SyncPostViewCount;
use App\Services\ViewCount\Sync\Dto\SyncViewCountDto;
use App\Services\ViewCount\Sync\Exceptions\SyncViewCountException;
use Illuminate\Redis\Connections\Connection;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use Tests\UnitTestCase;

class SyncPostViewCountTest extends UnitTestCase
{
    private SyncPostViewCount $sut;

    private Connection|(M\MockInterface&M\LegacyMockInterface) $connectionMock;

    private PostRepositoryInterface|(M\MockInterface&M\LegacyMockInterface) $postRepositoryMock;

    private (M\MockInterface&M\LegacyMockInterface)|Post $postMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connectionMock = M::mock(Connection::class);
        $this->postMock = M::mock(Post::class)->shouldAllowMockingProtectedMethods();
        $this->postRepositoryMock = M::mock(PostRepositoryInterface::class);

        $this->sut = new SyncPostViewCount($this->connectionMock, $this->postRepositoryMock);
    }

    #[Test]
    public function shouldSyncPostViewCount()
    {
        $key = "post:1:views";
        $id = 1;
        $viewCount = 5;

        $syncViewCountDto = new SyncViewCountDto(
            key: $key,
            type: 'post',
            id: $id,
        );
        $this->postRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($this->postMock);

        $this->connectionMock
            ->shouldReceive('get')
            ->once()
            ->with($key)
            ->andReturn($viewCount);

        $this->postMock
            ->shouldReceive('increment')
            ->once()
            ->with('view_count', $viewCount);

        $this->connectionMock
            ->shouldReceive('del')
            ->once()
            ->with($key);

        $result = $this->sut->run($syncViewCountDto);

        $this->assertNull($result);
    }

    #[Test]
    public function doNotSyncPostViewCountWhenPostNotFound()
    {
        $key = "post:2:views";
        $id = 2;

        $syncViewCountDto = new SyncViewCountDto(
            key: $key,
            type: 'post',
            id: $id,
        );

        $this->postRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn(null);

        $this
            ->connectionMock
            ->shouldNotReceive('get');

        $this
            ->postMock
            ->shouldNotReceive('increment');

        $this
            ->connectionMock
            ->shouldNotReceive('del');

        $result = $this->sut->run($syncViewCountDto);

        $this->assertNull($result);
    }

    #[Test]
    public function itShouldThrowExceptionWhenSyncPostViewCount()
    {
        $key = "post:3:views";
        $id = 3;

        $syncViewCountDto = new SyncViewCountDto(
            key: $key,
            type: 'post',
            id: $id,
        );

        $this->postRepositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andThrow(new \Exception('DB error'));

        $this->expectException(SyncViewCountException::class);

        $this->sut->run($syncViewCountDto);
    }
}
