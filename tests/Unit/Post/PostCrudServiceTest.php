<?php

namespace Tests\Unit\Post;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\Auth\Exceptions\LoginException;
use App\Services\Auth\LoginService;
use App\Services\Post\PostCrudService;
use App\Services\ViewCount\Contracts\ViewCountInterface;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Pagination\LengthAwarePaginator;
use Mockery as M;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class PostCrudServiceTest extends TestCase
{
    private PostCrudService $sut;

    private PostRepositoryInterface|(M\MockInterface&M\LegacyMockInterface) $postRepositoryMock;

    private ViewCountInterface|(M\MockInterface&M\LegacyMockInterface) $viewCountMock;

    private LengthAwarePaginator|(M\MockInterface&M\LegacyMockInterface) $lengthAwarePaginatorMock;

    private Post|(M\MockInterface&M\LegacyMockInterface) $postMock;

    protected function setUp(): void
    {
        parent::setUp();
        $this->postRepositoryMock = M::mock(PostRepositoryInterface::class);
        $this->viewCountMock = M::mock(ViewCountInterface::class);
        $this->lengthAwarePaginatorMock = M::mock(LengthAwarePaginator::class);
        $this->postMock = M::mock(Post::class);

        $this->sut = new PostCrudService($this->postRepositoryMock, $this->viewCountMock);
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

        $this->viewCountMock
            ->expects('incrementViewCount')
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
