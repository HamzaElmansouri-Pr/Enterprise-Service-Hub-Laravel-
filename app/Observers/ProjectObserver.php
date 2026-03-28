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
        if ($project->image && !str_starts_with($project->image, 'assets/')) {
            Storage::disk('public')->delete($project->image);
        }
    }

    /**
     * Handle the Project "updated" event to clean up old images.
     */
    public function updated(Project $project): void
    {
        if ($project->isDirty('image')) {
            $oldImage = $project->getOriginal('image');
            if ($oldImage && !str_starts_with($oldImage, 'assets/')) {
                Storage::disk('public')->delete($oldImage);
            }
        }
    }
}
