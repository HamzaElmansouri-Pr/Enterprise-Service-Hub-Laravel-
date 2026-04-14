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

        if (!empty($data['image_url'])) {
            if ($project && ($project->image !== $data['image_url'])) {
                $this->deleteLocalMedia($project->image);
            }

            $data['image'] = $data['image_url'];
        }

        if (!empty($data['og_image_url'])) {
            if ($project && (($project->og_image ?? null) !== $data['og_image_url'])) {
                $this->deleteLocalMedia($project->og_image ?? null);
            }

            $data['og_image'] = $data['og_image_url'];
        }

        // 3. Handle Main Image
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($project) {
                $this->deleteLocalMedia($project->image);
            }

            $data['image'] = $this->processImage($data['image'], $data['title']);
        }

        // 4. Handle OG Image
        if (isset($data['og_image']) && $data['og_image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($project) {
                $this->deleteLocalMedia($project->og_image ?? null);
            }

            $path = $data['og_image']->store('seo/og');
            $data['og_image'] = $path;
        }

        unset($data['image_url'], $data['og_image_url']);

        // 5. Create or Update
        if ($project) {
            $project->update($data);
            return $project;
        }

        return Project::create($data);
    }

    protected function processImage($file, string $title): string
    {
        $path = $file->store('projects');
        return $path;
    }

    protected function deleteLocalMedia(?string $path): void
    {
        if (empty($path) || $this->isExternalUrl($path) || str_starts_with($path, 'assets/')) {
            return;
        }

        if (str_starts_with($path, 'storage/')) {
            $path = substr($path, 8);
        }

        Storage::delete($path);
    }

    protected function isExternalUrl(string $path): bool
    {
        return str_starts_with($path, 'http://') || str_starts_with($path, 'https://');
    }
}
