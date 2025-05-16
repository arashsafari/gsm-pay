<?php

namespace App\Services\User\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface UserMostViewedPostsInterface
{
    public function getUserPostViewsRanking(): Collection;
}
