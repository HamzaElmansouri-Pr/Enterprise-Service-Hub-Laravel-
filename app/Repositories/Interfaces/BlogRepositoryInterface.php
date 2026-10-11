<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Blog;

interface BlogRepositoryInterface extends RepositoryInterface
{
    public function getFilteredActive(int $perPage = 10, string $category = '', string $search = '', string $sort = 'published_at', string $direction = 'desc', $isActive = true): LengthAwarePaginator;
    public function findBySlug(string $slug): Blog;
    public function getActiveCategories(): \Illuminate\Support\Collection;
    public function getRecent(Blog $currentBlog, int $limit = 3): Collection;
    public function getPublished(int $limit = null, bool $paginate = false);
    public function getFeatured(int $limit = 3);
    public function getRelated(int $currentId, ?string $category, int $limit = 3);
    public function getCategoriesWithCount();
    public function getPopularTags(int $limit = 9);
    public function getDistinctCategories();
}
