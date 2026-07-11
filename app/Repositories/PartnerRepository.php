<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Partner;
use App\Repositories\Interfaces\PartnerRepositoryInterface;

class PartnerRepository extends BaseRepository implements PartnerRepositoryInterface
{
    public function __construct(Partner $model)
    {
        parent::__construct($model);
    }
}
