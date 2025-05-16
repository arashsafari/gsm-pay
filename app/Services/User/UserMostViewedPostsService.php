<?php

namespace App\Services\User;

use App\Repositories\Contracts\UserRepositoryInterface;
use App\Services\User\Contracts\UserMostViewedPostsInterface;
use Illuminate\Database\Eloquent\Collection;

class UserMostViewedPostsService implements UserMostViewedPostsInterface
{
    public function __construct(private readonly UserRepositoryInterface $userRepository)
    {
    }

    public function getUserPostViewsRanking(): Collection
    {
        return $this->userRepository->getUserPostViewsRanking();
    }
}
