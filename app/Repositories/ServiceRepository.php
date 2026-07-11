<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Service;

class ServiceRepository extends BaseRepository implements \App\Repositories\Interfaces\ServiceRepositoryInterface
{
    public function __construct(Service $model)
    {
        parent::__construct($model);
    }
    
    /**
    * Get underlying model instance.
    */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get active services ordered by order_index.
     */
    public function getActive(int $limit = null): \Illuminate\Database\Eloquent\Collection
    {
        $query = clone $this->model->where('is_active', true)->orderBy('order_index');
        
        if ($limit) {
            $query->take($limit);
        }
        
        return $query->get();
    }

    public function findBySlug(string $slug)
    {
        return $this->model->where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function getFilteredActive(int $perPage = 12, ?string $search = null, string $sort = 'order_index', string $direction = 'asc', $isActive = true): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if ($isActive !== 'all') {
            $query->where('is_active', filter_var($isActive, FILTER_VALIDATE_BOOLEAN));
        }

        if (!empty($search)) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        if (in_array($sort, ['order_index', 'created_at', 'title'])) {
            $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');
        }

        return $query->paginate($perPage);
    }
}
?>
