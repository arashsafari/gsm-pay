<?php

namespace Tests\Unit\ViewCount;

use App\Services\ViewCount\ViewCountService;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ViewCountServiceTest extends TestCase
{
    private ViewCountService $sut;

    private CacheRepository|(M\MockInterface&M\LegacyMockInterface) $cacheMock;

    private Request|(M\MockInterface&M\LegacyMockInterface) $requestMock;

    private (M\MockInterface&M\LegacyMockInterface)|Model $modelMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cacheMock = M::mock(CacheRepository::class);
        $this->requestMock = M::mock(Request::class);
        $this->modelMock = M::mock(Model::class)->shouldAllowMockingProtectedMethods();

        $this->sut = new ViewCountService($this->cacheMock, $this->requestMock);
    }

    #[Test]
    public function dontIncreaseModeViewCount()
    {
        $getMorphClass = $this->modelMock
            ->expects('getMorphClass')
            ->andReturn('model');

        $getKey = $this->modelMock
            ->expects('getKey')
            ->andReturn('key');

        $ip = $this->requestMock
            ->expects('ip')
            ->andReturn('192.168.1.1');

        $this->cacheMock
            ->expects('has')
            ->andReturnTrue();

        $result = $this->sut->incrementViewCount($this->modelMock);

        $this->assertEquals($result, null);
    }

    #[Test]
    public function shouldIncreaseModeViewCount()
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

        $this->cacheMock
            ->expects('has')
            ->andReturnFalse();

        $this->modelMock
            ->expects('increment')
            ->andReturn(1);

        $this->cacheMock
            ->expects('put')
            ->andReturnTrue();

        $result = $this->sut->incrementViewCount($this->modelMock);

        $this->assertNull($result);
    }
}
