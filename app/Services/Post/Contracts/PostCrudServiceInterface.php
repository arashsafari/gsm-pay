<?php

namespace App\Services\Post\Contracts;

use App\Models\Post;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

interface PostCrudServiceInterface
{
    public function getAllPostWithPagination(int $perPage, int $page): LengthAwarePaginator;

    public function findPostAndUpdateView(int $id): Model|Post;
}
