<?php

namespace App\Services\ViewCount;

use App\Services\ViewCount\Contracts\ViewCountInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Cache\Repository as CacheRepository;
use Illuminate\Http\Request;

class ViewCountService implements ViewCountInterface
{
    public function __construct(
        private readonly CacheRepository $cache,
        private readonly Request         $request
    )
    {
    }

    public function incrementViewCount(Model $model): void
    {
        $cacheKey = sprintf(
            '%s_view_count_%d_%s',
            $model->getMorphClass(),
            $model->getKey(),
            $this->request->ip()
        );

        if ($this->cache->has($cacheKey)) {
            return;
        }

        $model->increment('view_count');

        $this->cache->put($cacheKey, true, 30 * 24 * 60 * 60);
    }
}
