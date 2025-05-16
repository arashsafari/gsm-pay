<?php

namespace Tests\Unit\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\User\UserMostViewedPostsService;
use Illuminate\Database\Eloquent\Collection;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class UserMostViewedPostsServiceTest extends TestCase
{
    private UserMostViewedPostsService $sut;

    private UserRepositoryInterface|(M\MockInterface&M\LegacyMockInterface) $userRepositoryMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepositoryMock = M::mock(UserRepositoryInterface::class);

        $this->sut = new UserMostViewedPostsService($this->userRepositoryMock);
    }

    #[Test]
    public function shouldGetUserPostViewsRanking()
    {
        $this->userRepositoryMock
            ->expects('getUserPostViewsRanking')
            ->andReturn(Collection::make());

        $result = $this->sut->getUserPostViewsRanking();

        $this->assertInstanceOf(Collection::class, $result);
    }
}
