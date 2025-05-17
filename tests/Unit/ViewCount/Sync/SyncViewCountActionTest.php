<?php

namespace Tests\Unit\ViewCount\Sync;

use App\Services\ViewCount\Sync\Drivers\SyncPostViewCount;
use App\Services\ViewCount\Sync\Dto\SyncViewCountDto;
use App\Services\ViewCount\Sync\Exceptions\SyncViewCountException;
use App\Services\ViewCount\Sync\SyncViewCountAction;
use Exception;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use Tests\UnitTestCase;

class SyncViewCountActionTest extends UnitTestCase
{
    private SyncViewCountAction $sut;

    private SyncPostViewCount|(M\MockInterface&M\LegacyMockInterface) $syncPostViewCountMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->syncPostViewCountMock = M::mock(SyncPostViewCount::class);

        $this->sut = new SyncViewCountAction($this->syncPostViewCountMock);
    }

    #[Test]
    public function itShouldSyncPostViewCountForPostKeys()
    {
        $keys = ['post:123:views'];

        $this->syncPostViewCountMock
            ->shouldReceive('run')
            ->once()
            ->withArgs(function (SyncViewCountDto $dto) use ($keys) {
                return $dto->getKey() === $keys[0]
                    && $dto->getType() === 'post'
                    && $dto->getId() === 123;
            });

        $this->sut->run($keys);
        $this->assertTrue(true);
    }

    #[Test]
    public function itShouldDoNotCallDriveWhenUnknownTypes()
    {
        $keys = ['unknown:999:views'];
        $this->syncPostViewCountMock->shouldNotReceive('run');
        $this->sut->run($keys);
        $this->assertTrue(true);
    }

    #[Test]
    public function itShouldThrowWhenSyncViewCountException()
    {
        $keys = ['post:1:views'];

        $this->syncPostViewCountMock
            ->shouldReceive('run')
            ->once()
            ->andThrow(new Exception('Some error'));

        $this->expectException(SyncViewCountException::class);
        $this->sut->run($keys);
    }
}
