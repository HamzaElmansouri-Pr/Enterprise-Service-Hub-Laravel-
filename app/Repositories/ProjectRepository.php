<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ProjectRepository extends BaseRepository implements ProjectRepositoryInterface
{
    public function __construct(Project $model)
    {
        parent::__construct($model);
    }

    public function getActive(?int $limit = null): Collection
    {
        $query = clone $this->model->where('is_active', true)->orderBy('order_index');
        
        if ($limit) {
            $query->take($limit);
        }
        
        return $query->get();
    }

    public function getFilteredActive(int $perPage = 12, string $category = '', string $search = '', string $sort = 'order_index', string $direction = 'asc', $isActive = true): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->model->newQuery()->with('categories');

        if ($isActive !== 'all') {
            $query->where('is_active', filter_var($isActive, FILTER_VALIDATE_BOOLEAN));
        }

        if ($category) {
            $query->where(function ($q) use ($category) {
                $q->where('category', $category)
                  ->orWhere('category', 'like', "%{$category}%")
                  ->orWhereHas('categories', function ($cq) use ($category) {
                      $cq->where('slug', $category)
                         ->orWhere('name->en', $category)
                         ->orWhere('name->ar', $category)
                         ->orWhere('name->fr', $category);
                  });
            });
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (in_array($sort, ['order_index', 'created_at', 'title', 'completion_date'])) {
            $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');
        }

        return $query->paginate($perPage);
    }

    public function findBySlug(string $slug): Project
    {
        return $this->model->with('categories')->where('slug', $slug)->where('is_active', true)->firstOrFail();
    }

    public function getActiveCategories(): \Illuminate\Support\Collection
    {
        $categories = \App\Models\Category::where('is_active', true)
            ->orderBy('order_index')
            ->get();

        if ($categories->isNotEmpty()) {
            return $categories->map(fn($c) => get_content_value($c->name))->unique()->values();
        }

        return $this->model->where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category')
            ->filter()
            ->values();
    }

    public function getRelatedProjects(Project $project, int $limit = 3): Collection
    {
        return $this->model->where('is_active', true)
            ->where('id', '!=', $project->id)
            ->inRandomOrder()
            ->take($limit)
            ->get();
    }
    
    public function getRelated(int $currentId, ?string $category, int $limit = 3) {
        return $this->model->where('is_active', true)->where('id', '!=', $currentId)->take($limit)->get();
    }
    public function getPrevious(int $currentId) { return null; }
    public function getNext(int $currentId) { return null; }
    public function getDistinctCategories() { return $this->getActiveCategories(); }
}
?>
