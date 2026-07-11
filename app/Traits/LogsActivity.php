<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    /**
     * Boot the trait and register Eloquent event observers.
     */
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            $model->logActivity('created');
        });

        static::updated(function ($model) {
            $model->logActivity('updated');
        });

        static::deleted(function ($model) {
            $model->logActivity('deleted');
        });
    }

    /**
     * Log the activity for the model.
     *
     * @param string $eventName
     */
    public function logActivity(string $eventName)
    {
        // Don't log if running from CLI (e.g., migrations, seeders) unless we want to
        if (app()->runningInConsole()) {
            return;
        }

        $causer = Auth::user();

        $changes = [];
        if ($eventName === 'updated') {
            $changes = [
                'attributes' => $this->getDirty(),
                'old' => array_intersect_key($this->getOriginal(), $this->getDirty()),
            ];
        }

        ActivityLog::create([
            'log_name' => 'default',
            'description' => ucfirst($eventName) . ' ' . class_basename($this),
            'subject_type' => get_class($this),
            'subject_id' => $this->getKey(),
            'causer_type' => $causer ? get_class($causer) : null,
            'causer_id' => $causer ? $causer->id : null,
            'properties' => !empty($changes) ? $changes : null,
        ]);
    }
}
