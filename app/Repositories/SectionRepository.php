<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Section;
use App\Repositories\Interfaces\SectionRepositoryInterface;

class SectionRepository extends BaseRepository implements SectionRepositoryInterface
{
    public function __construct(Section $model)
    {
        parent::__construct($model);
    }
}
