<?php

declare(strict_types=1);

namespace App\Repositories\Interfaces;

interface SliderRepositoryInterface extends RepositoryInterface
{
    public function getActive(int $limit = null);
}
