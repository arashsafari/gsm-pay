<?php

namespace App\Services\ViewCount\Sync\Contracts;

use Illuminate\Database\Eloquent\Model;

interface SyncViewCountInterface
{
    public function run(array $keys): void;
}
