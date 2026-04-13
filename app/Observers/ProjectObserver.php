<?php

namespace App\Observers;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;

class ProjectObserver
{
    /**
     * Handle the Project "deleted" event.
     */
    public function deleted(Project $project): void
    {
        if ($project->image && !str_starts_with($project->image, 'assets/') && !$this->isExternalUrl($project->image)) {
            Storage::disk('public')->delete($this->normalizePath($project->image));
        }
    }

    /**
     * Handle the Project "updated" event to clean up old images.
     */
    public function updated(Project $project): void
    {
        if ($project->isDirty('image')) {
            $oldImage = $project->getOriginal('image');
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
