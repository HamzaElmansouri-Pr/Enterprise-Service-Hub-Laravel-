<?php

namespace App\Actions\Projects;

use App\Models\Project;
use App\Services\CloudinaryUploadService;
use Illuminate\Support\Str;

class SaveProjectAction
{
    protected CloudinaryUploadService $uploadService;

    public function __construct(CloudinaryUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

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
            $titleForSlug = is_array($data['title']) ? ($data['title']['en'] ?? reset($data['title'])) : $data['title'];
            $data['slug'] = Str::slug($titleForSlug);
        }

        // 2. Handle HTML Purification
        if (function_exists('purify_html')) {
            if (isset($data['title'])) {
                $data['title'] = is_array($data['title']) ? array_map('strip_tags', $data['title']) : strip_tags($data['title']);
            }
            if (isset($data['description'])) {
                $data['description'] = is_array($data['description']) ? array_map('purify_html', $data['description']) : purify_html($data['description']);
            }
        }

        if (!empty($data['image_url'])) {
            if ($project && ($project->image !== $data['image_url'])) {
                $this->uploadService->delete($project->image);
            }
            $data['image'] = $data['image_url'];
        } elseif (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($project) {
                $this->uploadService->delete($project->image);
            }
            $data['image'] = $this->uploadService->upload($data['image'], 'projects');
        } else {
            unset($data['image']);
        }

        // 4. Handle OG Image
        if (!empty($data['og_image_url'])) {
            if ($project && (($project->og_image ?? null) !== $data['og_image_url'])) {
                $this->uploadService->delete($project->og_image ?? null);
            }
            $data['og_image'] = $data['og_image_url'];
        } elseif (isset($data['og_image']) && $data['og_image'] instanceof \Illuminate\Http\UploadedFile) {
            if ($project) {
                $this->uploadService->delete($project->og_image ?? null);
            }
            $data['og_image'] = $this->uploadService->upload($data['og_image'], 'seo/og');
        } else {
            unset($data['og_image']);
        }

        unset($data['image_url'], $data['og_image_url']);

        // 5. Handle Categories
        $categoryIds = null;
        if (array_key_exists('category_ids', $data)) {
            $categoryIds = $data['category_ids'] ?? [];
            unset($data['category_ids']);

            // Update legacy category string for backwards compatibility
            if (!empty($categoryIds)) {
                $selectedCats = \App\Models\Category::whereIn('id', $categoryIds)->get();
                $data['category'] = $selectedCats->first()?->name;
            } else {
                $data['category'] = null;
            }
        }
        unset($data['categories_submitted']);

        // 6. Create or Update
        if ($project) {
            $project->update($data);
        } else {
            $project = Project::create($data);
        }

        if ($categoryIds !== null) {
            $project->categories()->sync($categoryIds);
        }

        return $project;
    }
}
