<?php

namespace App\Services\Post;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\Post\Contracts\PostCrudServiceInterface;
use App\Services\ViewCount\Increment\Contracts\IncrementCountInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class PostCrudService implements PostCrudServiceInterface
{
    public function __construct(
        private readonly PostRepositoryInterface $postRepository,
        private readonly IncrementCountInterface $incrementCount,
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
        $this->incrementCount->run($post);

        return $post;
    }
}
