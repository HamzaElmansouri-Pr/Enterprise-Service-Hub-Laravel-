<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Review;
use App\Repositories\Interfaces\ReviewRepositoryInterface;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function __construct(Review $model)
    {
        parent::__construct($model);
    }

    public function getApproved(int $limit = null, bool $featuredOnly = false)
    {
        $query = $this->model->where('is_approved', true);
        
        if ($featuredOnly) {
            $query->where('is_featured', true);
        }
        
        $query->orderBy('created_at', 'desc');
        
        if ($limit) {
            return $query->take($limit)->get();
        }
        
        return $query->get();
    }
}
