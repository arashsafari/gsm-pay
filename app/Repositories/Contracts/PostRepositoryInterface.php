<?php

namespace App\Repositories\Contracts;

use Illuminate\Pagination\LengthAwarePaginator;

interface PostRepositoryInterface
{
    public function getAllPosts(int $perPage, int $page, array|string $columns = ['*']): LengthAwarePaginator;
}
