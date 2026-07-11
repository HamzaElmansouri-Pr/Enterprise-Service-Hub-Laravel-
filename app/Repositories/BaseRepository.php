<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Interfaces\RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository implements RepositoryInterface
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->all();
    }

    public function find(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function findOrFail(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data): bool
    {
        $record = $this->model->find($id);
        if (!$record) {
            return false;
        }
        return $record->update($data);
    }

    public function delete(int $id): bool
    {
        $record = $this->model->find($id);
        if (!$record) {
            return false;
        }
        return $record->delete();
    }

    public function paginate(int $perPage = 10, array $with = [], array $orderBy = ['created_at' => 'desc']): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($with)) {
            $query->with($with);
        }

        foreach ($orderBy as $column => $direction) {
            $query->orderBy($column, $direction);
        }

        return $query->paginate($perPage);
    }

    public function getActive(?int $limit = null): Collection
    {
        $query = in_array('is_active', $this->model->getFillable()) 
            ? $this->model->where('is_active', true) 
            : $this->model->newQuery();
            
        if ($limit !== null) {
            $query->take($limit);
        }
        
        return $query->get();
    }
}
