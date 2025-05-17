<?php

namespace App\Console\Commands;

use App\Services\ViewCount\Sync\SyncViewCountAction;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Redis;

class SyncViewCountCommand extends Command
{
    protected $signature = 'app:sync-view-count-command';

    protected $description = 'Command description';

    protected const CACHE_KEY_PATTERNS = '*:views';

    public function handle(SyncViewCountAction $syncViewCountAction)
    {
        $keys = Redis::keys(self::CACHE_KEY_PATTERNS);

        if (!empty($keys)) {
            $syncViewCountAction->run($keys);
        }

        $this->info('View counts synced successfully.');
    }
}
