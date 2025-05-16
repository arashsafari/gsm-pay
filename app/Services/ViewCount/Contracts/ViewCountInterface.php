<?php

namespace App\Services\ViewCount\Contracts;

use Illuminate\Database\Eloquent\Model;

interface ViewCountInterface
{
    public function incrementViewCount(Model $model): void;
}
