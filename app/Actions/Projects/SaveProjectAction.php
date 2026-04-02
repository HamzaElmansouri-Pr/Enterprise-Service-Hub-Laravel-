<?php

namespace App\Actions\Projects;

use App\Models\Project;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SaveProjectAction
{
    /**
     * Execute the action to save a project.
     * 
     * @param array $data
     * @param Project|null $project
     * @return Project
     */
    public function execute(array $data, ?Project $project = null): Project
    {
        // 1. Handle Slug
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        // 2. Handle HTML Purification
        if (function_exists('purify_html')) {
            if (isset($data['title'])) {
                $data['title'] = purify_html($data['title']);
            }
            if (isset($data['description'])) {
                $data['description'] = purify_html($data['description']);
            }
        }

        // 3. Handle Main Image
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->processImage($data['image'], $data['title']);
        }

        // 4. Handle OG Image
        if (isset($data['og_image']) && $data['og_image'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['og_image']->store('seo/og', 'public');
            $data['og_image'] = 'storage/' . $path;
        }

        // 5. Create or Update
        if ($project) {
            $project->update($data);
            return $project;
        }

        return Project::create($data);
    }

    /**
     * Process project image with optimization if available.
     */
    protected function processImage($file, string $title): string
    {
        $filename = Str::slug($title) . '-' . time();
        
        // Professional Optimization: Using Intervention Image if available
        if (class_exists('\Intervention\Image\Laravel\Facades\Image')) {
            $manager = \Intervention\Image\Laravel\Facades\Image::getFacadeRoot();
            
            // 1. Optimized Main Image (WebP, Max 1200px)
            $mainPath = 'projects/' . $filename . '.webp';
            $image = $manager->read($file);
            $image->scale(width: 1200);
            Storage::disk('public')->put($mainPath, (string) $image->toWebp(80));
            
            // 2. Thumbnail (WebP, 400x300 Cover)
            $thumbPath = 'projects/thumbs/' . $filename . '.webp';
            $thumb = $manager->read($file);
            $thumb->cover(400, 300);
            Storage::disk('public')->put($thumbPath, (string) $thumb->toWebp(70));
            
            return 'storage/' . $mainPath;
        }

        // Fallback to standard upload
        $path = $file->store('projects', 'public');
        return 'storage/' . $path;
    }
}
