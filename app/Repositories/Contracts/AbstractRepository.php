<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Throwable;

abstract class AbstractRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->setInstance();
    }

    abstract protected function instance(array $attributes = []): Model;

    public function find($id, array $columns = ['*']): ?Model
    {
        return $this->getQuery()->find($id, $columns);
    }

    public function findOrFail($id, array $columns = ['*']): Model|ModelNotFoundException
    {
        return $this->getQuery()->findOrFail($id, $columns);
    }

    protected function setInstance(array $attributes = []): Model
    {
        $this->model = $this->instance($attributes);

        return $this->model;
    }

    protected function getQuery(): Builder
    {
        return $this->model->newQuery();
    }
}
