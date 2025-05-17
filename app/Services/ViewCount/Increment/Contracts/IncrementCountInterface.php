<?php

namespace App\Services\ViewCount\Increment\Contracts;

use Illuminate\Database\Eloquent\Model;

interface IncrementCountInterface
{
    public function run(Model $model): void;
}
