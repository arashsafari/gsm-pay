<?php

declare(strict_types=1);

namespace App\Services\ViewCount\Sync\Exceptions;

use Exception;

class SyncViewCountException extends Exception
{
    public static function whenSyncViewCountFaild(string $key): self
    {
        return new static("Failed to sync view count for key $key");
    }
}
