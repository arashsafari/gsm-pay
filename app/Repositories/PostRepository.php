<?php

namespace App\Repositories;

use App\Models\Post;
use App\Repositories\Contracts\AbstractRepository;
use App\Repositories\Contracts\PostRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;

class PostRepository extends AbstractRepository implements PostRepositoryInterface
{
    public function getAllPosts(int $perPage, int $page, array|string $columns = ['*']): LengthAwarePaginator
    {
        return $this->getQuery()
            ->with([
                'user:id,mobile',
                'user.media:id,uuid,model_id,model_type,collection_name,mime_type,disk,name,file_name'
            ])
            ->paginate(
                perPage: $perPage,
                columns: $columns,
                page: $page,
            );
    }

    protected function instance(array $attributes = []): Post
    {
        return new Post($attributes);
    }
}
