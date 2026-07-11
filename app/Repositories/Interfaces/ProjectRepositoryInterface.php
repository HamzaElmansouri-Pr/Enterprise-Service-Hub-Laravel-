<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Project;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function getFilteredActive(int $perPage = 12, string $category = '', string $search = '', string $sort = 'order_index', string $direction = 'asc', $isActive = true): LengthAwarePaginator;
    public function findBySlug(string $slug): Project;
    public function getActiveCategories(): \Illuminate\Support\Collection;
    public function getRelatedProjects(Project $project, int $limit = 3): Collection;
    public function getActive(?int $limit = null): Collection;
    public function getRelated(int $currentId, ?string $category, int $limit = 3);
    public function getPrevious(int $currentId);
    public function getNext(int $currentId);
    public function getDistinctCategories();
}
