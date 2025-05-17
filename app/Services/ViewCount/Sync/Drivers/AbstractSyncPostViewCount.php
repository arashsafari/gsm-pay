<?php

namespace App\Services\ViewCount\Sync\Drivers;

use App\Services\ViewCount\Sync\Dto\SyncViewCountDto;

abstract class AbstractSyncPostViewCount
{
    abstract public function run(SyncViewCountDto $syncViewCountDto): void;
}
