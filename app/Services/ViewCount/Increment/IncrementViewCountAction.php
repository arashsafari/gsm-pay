<?php

namespace App\Services\ViewCount\Increment;

use App\Services\ViewCount\Increment\Contracts\IncrementCountInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Redis\Connections\Connection;

class IncrementViewCountAction implements IncrementCountInterface
{
    private const VIEW_TTL_SECONDS = 86400; // 24 hours

    public function __construct(
        private readonly Connection $redis,
        private readonly Request    $request
    )
    {
    }

    public function run(Model $model): void
    {
        $modelType = $model->getMorphClass();
        $modelId = $model->getKey();
        $ip = $this->request->ip();

        $ipCacheKey = sprintf('%s:%d:views:ip:%s', $modelType, $modelId, $ip);
        $totalViewsKey = sprintf('%s:%d:views', $modelType, $modelId);

        if ($this->redis->get($ipCacheKey)) {
            return;
        }

        $this->redis->incr($totalViewsKey);

        $this->redis->setex($ipCacheKey, self::VIEW_TTL_SECONDS, 1);
    }
}
