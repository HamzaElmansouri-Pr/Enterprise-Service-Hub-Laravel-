<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Slider;
use App\Repositories\Interfaces\SliderRepositoryInterface;

class SliderRepository extends BaseRepository implements SliderRepositoryInterface
{
    public function __construct(Slider $model)
    {
        parent::__construct($model);
    }
}
