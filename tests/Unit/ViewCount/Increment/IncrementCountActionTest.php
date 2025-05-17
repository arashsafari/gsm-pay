<?php

namespace Tests\Unit\ViewCount\Increment;

use App\Services\ViewCount\Increment\IncrementViewCountAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Redis\Connections\Connection;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use Tests\UnitTestCase;

class IncrementCountActionTest extends UnitTestCase
{
    private IncrementViewCountAction $sut;

    private Connection|(M\MockInterface&M\LegacyMockInterface) $connectionMock;

    private Request|(M\MockInterface&M\LegacyMockInterface) $requestMock;

    private (M\MockInterface&M\LegacyMockInterface)|Model $modelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->connectionMock = M::mock(Connection::class);
        $this->requestMock = M::mock(Request::class);
        $this->modelMock = M::mock(Model::class)->shouldAllowMockingProtectedMethods();

        $this->sut = new IncrementViewCountAction($this->connectionMock, $this->requestMock);
    }

    #[Test]
    public function dontIncrementModeViewCount()
    {
        $this->modelMock
            ->expects('getMorphClass')
            ->andReturn('model');

        $this->modelMock
            ->expects('getKey')
            ->andReturn('key');

        $this->requestMock
            ->expects('ip')
            ->andReturn('192.168.1.1');

        $this->connectionMock
            ->expects('get')
            ->andReturn('cache_key');

        $result = $this->sut->run($this->modelMock);

        $this->assertNull($result);
    }

    #[Test]
    public function shouldIncrementModeViewCount()
    {
        $this->modelMock
            ->expects('getMorphClass')
            ->andReturn('model');

        $this->modelMock
            ->expects('getKey')
            ->andReturn('key');

        $this->requestMock
            ->expects('ip')
            ->andReturn('192.168.1.1');

        $this->connectionMock
            ->expects('get')
            ->andReturnNull();

        $this->connectionMock
            ->expects('incr')
            ->andReturnTrue();

        $this->connectionMock
            ->expects('setex')
            ->andReturnTrue();

        $result = $this->sut->run($this->modelMock);

        $this->assertNull($result);
    }
}
