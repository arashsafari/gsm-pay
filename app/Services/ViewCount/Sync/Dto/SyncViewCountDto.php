<?php

namespace App\Services\ViewCount\Sync\Dto;

use Spatie\LaravelData\Data;

class SyncViewCountDto extends Data
{
    public function __construct(
        protected string $key,
        protected string $type,
        protected int $id,
    )
    {
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
