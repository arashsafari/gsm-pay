<?php

namespace App\Http\Controllers\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Services\Post\Contracts\PostCrudServiceInterface;
use Exception;
use Illuminate\Http\JsonResponse;

class PostController extends Controller
{
    public function __construct(
        private readonly PostCrudServiceInterface $postService,
    )
    {
    }

    public function index(): JsonResponse
    {
        $perPage = request()->input('per_page') ?? config('pagination.per_page');
        $page = request()->input('page') ?? config('pagination.default_page');

        $posts = $this->postService->getAllPostWithPagination($perPage, $page);

        return $this->success(PostResource::collection($posts));

    }

    public function show(int $id): JsonResponse
    {
        try {
            $post = $this->postService->findPostAndUpdateView($id);
        } catch (Exception $exception) {
            return $this->error($exception->getMessage(), 404);
        }

        return $this->success(PostResource::make($post));
    }
}
