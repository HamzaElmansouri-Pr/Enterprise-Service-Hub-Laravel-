<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface BlogRepositoryInterface extends RepositoryInterface
{
    public function getPublished(int $limit = null, bool $paginate = false);
    public function getFeatured(int $limit = 3);
    public function getRelated(int $currentId, ?string $category, int $limit = 3);
    public function getCategoriesWithCount();
    public function getPopularTags(int $limit = 9);
    public function getDistinctCategories();
}
