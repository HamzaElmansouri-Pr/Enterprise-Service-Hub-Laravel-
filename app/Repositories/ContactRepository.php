<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Contact;
use App\Repositories\Interfaces\ContactRepositoryInterface;

class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{
    public function __construct(Contact $model)
    {
        parent::__construct($model);
    }

    public function markAllAsRead(): bool
    {
        return (bool) $this->model->where('is_read', false)->update(['is_read' => true]);
    }
}
