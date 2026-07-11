<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\Collection;

interface SliderRepositoryInterface extends RepositoryInterface
{
    public function getActive(?int $limit = null): Collection;
}
