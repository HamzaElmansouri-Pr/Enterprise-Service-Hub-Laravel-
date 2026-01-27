<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\TcRequest;
use App\Repositories\Interfaces\TcRequestRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class TcRequestRepository extends BaseRepository implements TcRequestRepositoryInterface
{
    public function __construct(TcRequest $model)
    {
        parent::__construct($model);
    }
    
    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return $this->model->with('service')->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
