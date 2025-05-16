<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserMostViewedPostsResource;
use App\Services\User\Contracts\UserMostViewedPostsInterface;
use Illuminate\Http\JsonResponse;

class UserMostViewedPostsController extends Controller
{
    public function __construct(
        private readonly UserMostViewedPostsInterface $mostViewedPosts,
    )
    {
    }

    public function __invoke(): JsonResponse
    {
        $users = $this->mostViewedPosts->getUserPostViewsRanking();

        return $this->success(UserMostViewedPostsResource::collection($users));

    }
}
