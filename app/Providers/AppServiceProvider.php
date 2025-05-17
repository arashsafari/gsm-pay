<?php

namespace App\Providers;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\PostRepository;
use App\Repositories\UserRepository;
use App\Services\Post\Contracts\PostCrudServiceInterface;
use App\Services\Post\PostCrudService;
use App\Services\User\Contracts\UploadProfileImageInterface;
use App\Services\User\Contracts\UserMostViewedPostsInterface;
use App\Services\User\UploadProfileImageService;
use App\Services\User\UserMostViewedPostsService;
use App\Services\ViewCount\Increment\Contracts\IncrementCountInterface;
use App\Services\ViewCount\Increment\IncrementViewCountAction;
use App\Services\ViewCount\Sync\Contracts\SyncViewCountInterface;
use App\Services\ViewCount\Sync\SyncViewCountAction;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(UploadProfileImageInterface::class, UploadProfileImageService::class);
        $this->app->bind(UserMostViewedPostsInterface::class, UserMostViewedPostsService::class);
        $this->app->bind(PostCrudServiceInterface::class, PostCrudService::class);
        $this->app->bind(IncrementCountInterface::class, IncrementViewCountAction::class);
        $this->app->bind(SyncViewCountInterface::class, SyncViewCountAction::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::morphMap([
            'post' => Post::class,
        ]);
    }
}
