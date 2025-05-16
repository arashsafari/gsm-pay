<?php

namespace App\Repositories;

use App\Models\User;
use App\Repositories\Contracts\AbstractRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends AbstractRepository implements UserRepositoryInterface
{

    public function getUserPostViewsRanking(): Collection
    {
        return $this->getQuery()
            ->withSum('posts as total_post_views', 'view_count')
            ->orderByDesc('total_post_views')
            ->with([
                'posts:id,view_count,user_id',
                'media:id,uuid,model_id,model_type,collection_name,mime_type,disk,name,file_name'
            ])
            ->get();
    }

    protected function instance(array $attributes = []): User
    {
        return new User($attributes);
    }
}
