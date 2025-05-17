<?php

namespace App\Services\ViewCount\Sync\Drivers;

use App\Repositories\Contracts\PostRepositoryInterface;
use App\Services\ViewCount\Sync\Dto\SyncViewCountDto;
use App\Services\ViewCount\Sync\Exceptions\SyncViewCountException;
use Illuminate\Redis\Connections\Connection;
use Throwable;

class SyncPostViewCount extends AbstractSyncPostViewCount
{
    public function __construct(
        private readonly Connection              $redis,
        private readonly PostRepositoryInterface $postRepository,
    )
    {
    }

    public function run(SyncViewCountDto $syncViewCountDto): void
    {
        try {
            $key = $syncViewCountDto->getKey();
            $id = $syncViewCountDto->getId();

            $post = $this->postRepository->find($id);
            if (!$post) {
                return;
            }

            $post->increment('view_count', (int)$this->redis->get($key));
            $this->redis->del($key);

        } catch (Throwable $e) {
            throw SyncViewCountException::whenSyncViewCountFaild($key);
        }
    }
}
