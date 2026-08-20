<?php

namespace App\Observers;

use App\Services\CacheInvalidator;
use Illuminate\Database\Eloquent\Model;

class CacheObserver
{
    protected CacheInvalidator $invalidator;

    public function __construct(CacheInvalidator $invalidator)
    {
        $this->invalidator = $invalidator;
    }

    /**
     * Handle the Model "saved" event (created or updated).
     */
    public function saved(Model $model): void
    {
        $this->invalidator->invalidateFor($model);
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        $this->invalidator->invalidateFor($model);
    }
}
