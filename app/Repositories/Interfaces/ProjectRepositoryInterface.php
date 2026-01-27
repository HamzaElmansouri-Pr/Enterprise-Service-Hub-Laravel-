<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface ProjectRepositoryInterface extends RepositoryInterface
{
    public function getActive(int $limit = null);
    public function getRelated(int $currentId, ?string $category, int $limit = 3);
    public function getPrevious(int $currentId);
    public function getNext(int $currentId);
    public function getDistinctCategories();
}
