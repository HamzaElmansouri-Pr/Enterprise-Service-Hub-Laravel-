<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface ServiceRepositoryInterface extends RepositoryInterface
{
    public function findBySlug(string $slug);

    public function getFilteredActive(int $perPage = 12, ?string $search = null, string $sort = 'order_index', string $direction = 'asc', $isActive = true): LengthAwarePaginator;

    public function getActive(int $limit = null): \Illuminate\Database\Eloquent\Collection;
}
