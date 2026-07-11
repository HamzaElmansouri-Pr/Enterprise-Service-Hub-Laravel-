<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class BlogRepository extends BaseRepository implements BlogRepositoryInterface
{
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }

    public function getPublishedOrdered()
    {
        return $this->model
            ->where('is_published', true)
            ->orderBy('order_index')
            ->get();
    }

    public function getFilteredActive(int $perPage = 10, string $search = '', string $sort = 'published_at', string $direction = 'desc', $isActive = true): \Illuminate\Pagination\LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if ($isActive !== 'all') {
            $query->where('is_active', filter_var($isActive, FILTER_VALIDATE_BOOLEAN));
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if (in_array($sort, ['published_at', 'created_at', 'title'])) {
            $query->orderBy($sort, $direction === 'desc' ? 'desc' : 'asc');
        }

        return $query->with('author')->paginate($perPage);
    }

    public function findBySlug(string $slug): Blog
    {
        return $this->model->where('slug', $slug)->where('is_active', true)->with('author')->firstOrFail();
    }

    public function getRecent(Blog $currentBlog, int $limit = 3): Collection
    {
        return $this->model->where('is_active', true)
            ->where('id', '!=', $currentBlog->id)
            ->orderBy('published_at', 'desc')
            ->take($limit)
            ->with('author')
            ->get();
    }
    
    public function getPublished(int $limit = null, bool $paginate = false) { return null; }
    public function getFeatured(int $limit = 3) { return null; }
    public function getRelated(int $currentId, ?string $category, int $limit = 3) { return null; }
    public function getCategoriesWithCount() { return collect(); }
    public function getPopularTags(int $limit = 9) { return collect(); }
    public function getDistinctCategories() { return collect(); }
}
?>
