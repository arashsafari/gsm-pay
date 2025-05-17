<?php

namespace App\Services\ViewCount\Sync;

use App\Services\ViewCount\Sync\Contracts\SyncViewCountInterface;
use App\Services\ViewCount\Sync\Drivers\SyncPostViewCount;
use App\Services\ViewCount\Sync\Dto\SyncViewCountDto;
use App\Services\ViewCount\Sync\Exceptions\SyncViewCountException;
use Throwable;

class SyncViewCountAction implements SyncViewCountInterface
{
    public function __construct(
        private readonly SyncPostViewCount $syncPostViewCount,
    )
    {
    }

    /**
     * @throws SyncViewCountException
     */
    public function run(array $keys): void
    {
        foreach ($keys as $key) {
            try {
                [$modelType, $modelId] = explode(':', $key);
                $syncViewCountDto = new SyncViewCountDto(
                    key: $key,
                    type: $modelType,
                    id: (int)$modelId,
                );

                match ($modelType) {
                    'post' => $this->syncPostViewCount->run($syncViewCountDto),
                    default => null,
                };
            } catch (Throwable $e) {
                throw SyncViewCountException::whenSyncViewCountFaild($key);
            }
        }
    }
}
