<?php

namespace Tests\Unit\Post;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\Post\PostCrudService;
use App\Services\ViewCount\Increment\Contracts\IncrementCountInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use Tests\UnitTestCase;

class PostCrudServiceTest extends UnitTestCase
{
    private PostCrudService $sut;

    private PostRepositoryInterface|(M\MockInterface&M\LegacyMockInterface) $postRepositoryMock;

    private IncrementCountInterface|(M\MockInterface&M\LegacyMockInterface) $incrementCountInterfaceMock;

    private LengthAwarePaginator|(M\MockInterface&M\LegacyMockInterface) $lengthAwarePaginatorMock;

    private Post|(M\MockInterface&M\LegacyMockInterface) $postMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postRepositoryMock = M::mock(PostRepositoryInterface::class);
        $this->incrementCountInterfaceMock = M::mock(IncrementCountInterface::class);
        $this->lengthAwarePaginatorMock = M::mock(LengthAwarePaginator::class);
        $this->postMock = M::mock(Post::class);

        $this->sut = new PostCrudService($this->postRepositoryMock, $this->incrementCountInterfaceMock);
    }

    #[Test]
    public function shouldReturnAllPostsSuccessfully()
    {
        $this->postRepositoryMock
            ->expects('getAllPosts')
            ->andReturn($this->lengthAwarePaginatorMock);

        $result = $this->sut->getAllPostWithPagination(10, 1);

        $this->assertInstanceOf(LengthAwarePaginator::class, $result);
    }

    #[Test]
    public function shouldReturnPostDetailsSuccessfully()
    {
        $this->postRepositoryMock
            ->expects('findOrFail')
            ->andReturn($this->postMock);

        $this->incrementCountInterfaceMock
            ->expects('run')
            ->andReturnNull();

        $result = $this->sut->findPostAndUpdateView(1);

        $this->assertInstanceOf(Post::class, $result);
    }

    #[Test]
    public function shouldThrowExceptionWhenPostNotFound()
    {
        $this->postRepositoryMock
            ->expects('findOrFail')
            ->andThrow(ModelNotFoundException::class);

        $this->expectException(ModelNotFoundException::class);

        $this->sut->findPostAndUpdateView(1);
    }
}
