<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\Post\Contracts\PostCrudServiceInterface;
use App\Services\ViewCount\Contracts\ViewCountInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PostCrudService implements PostCrudServiceInterface
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
        private readonly ViewCountInterface      $viewCountService,
    )
    {
    }


    public function getAllPostWithPagination(int $perPage, int $page): LengthAwarePaginator
    {
        return $this->postRepository->getAllPosts(
            perPage: $perPage,
            page: $page,
            columns: ['id', 'title', 'body', 'view_count', 'user_id'],
        );
    }

    public function findPostAndUpdateView(int $id): Model|Post
    {
        $post = $this->postRepository->findOrFail(
            id: $id,
            columns: ['id', 'title', 'body', 'view_count', 'user_id'],
        );
        $this->viewCountService->incrementViewCount($post);

        return $post;
    }
}
