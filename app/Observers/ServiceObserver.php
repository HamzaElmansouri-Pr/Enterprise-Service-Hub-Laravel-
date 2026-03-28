<?php

namespace App\Observers;

use App\Models\Service;
use Illuminate\Support\Facades\Storage;

class ServiceObserver
{
    /**
     * Handle the Service "deleted" event.
     */
    public function deleted(Service $service): void
    {
        if ($service->image && !str_starts_with($service->image, 'assets/')) {
            Storage::disk('public')->delete($service->image);
        }
    }

    /**
     * Handle the Service "updated" event to clean up old images.
     */
    public function updated(Service $service): void
    {
        if ($service->isDirty('image')) {
            $oldImage = $service->getOriginal('image');
            if ($oldImage && !str_starts_with($oldImage, 'assets/')) {
                Storage::disk('public')->delete($oldImage);
            }
        }
    }
}
