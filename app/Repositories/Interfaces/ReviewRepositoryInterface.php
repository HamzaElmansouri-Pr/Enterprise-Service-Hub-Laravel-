<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface ReviewRepositoryInterface extends RepositoryInterface
{
    public function getApproved(int $limit = null, bool $featuredOnly = false);
}
