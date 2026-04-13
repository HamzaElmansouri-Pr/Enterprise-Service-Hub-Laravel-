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
        if ($service->image && !str_starts_with($service->image, 'assets/') && !$this->isExternalUrl($service->image)) {
            Storage::disk('public')->delete($this->normalizePath($service->image));
        }
    }

    /**
     * Handle the Service "updated" event to clean up old images.
     */
    public function updated(Service $service): void
    {
        if ($service->isDirty('image')) {
            $oldImage = $service->getOriginal('image');
            if ($oldImage && !str_starts_with($oldImage, 'assets/') && !$this->isExternalUrl($oldImage)) {
                Storage::disk('public')->delete($this->normalizePath($oldImage));
            }
        }
    }

    private function isExternalUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }

    private function normalizePath(string $path): string
    {
        return str_starts_with($path, 'storage/') ? substr($path, 8) : $path;
    }
}
