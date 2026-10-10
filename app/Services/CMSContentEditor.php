<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Section;
use App\Services\CloudinaryUploadService;

class CMSContentEditor
{
    protected CMSValidationRules $validationRules;

    public function __construct(CMSValidationRules $validationRules)
    {
        $this->validationRules = $validationRules;
    }

    /**
     * Administration: Fetch or create a section by type.
     */
    public function getSection(string $type): Section
    {
        list($pageSlug, $sectionKey) = $this->parseType($type);
        
        $page = Page::firstOrCreate(['slug' => $pageSlug], [
            'title' => ucwords(str_replace('-', ' ', $pageSlug)),
            'is_home' => $pageSlug === 'home',
        ]);
        
        $section = $page->sections()->where('type', $type)->first();

        if (!$section && isset(['home-hero' => 'hero-3', 'home-about' => 'about-3'][$type])) {
            $legacyType = ['home-hero' => 'hero-3', 'home-about' => 'about-3'][$type];
            $section = $page->sections()->where('type', $legacyType)->first();

            if ($section) {
                // Normalize pre-CMS section names the first time they are edited.
                $section->update([
                    'type' => $type,
                    'name' => ucwords(str_replace('-', ' ', $sectionKey)),
                ]);
            }
        }

        return $section ?: $page->sections()->firstOrCreate(['type' => $type], [
            'name' => ucwords(str_replace('-', ' ', $sectionKey)),
            'is_active' => true,
        ]);
    }

    /**
     * Administration: Get raw content blocks for editing.
     */
    public function getSectionContentBlocks(Section $section, bool $localize = false): array
    {
        $content = $section->contentBlocks->mapWithKeys(function ($block) use ($localize) {
            return [$block->key => $localize ? $block->content : $block->getTranslations('content')];
        })->toArray();
        
        if (isset($content['features'])) {
            $jsonStr = is_array($content['features']) ? ($content['features']['en'] ?? '[]') : $content['features'];
            $content['features'] = json_decode($jsonStr, true);
        }
        
        if (isset($content['stats'])) {
            $jsonStr = is_array($content['stats']) ? ($content['stats']['en'] ?? '[]') : $content['stats'];
            $content['stats'] = json_decode($jsonStr, true);
        }

        if (isset($content['values'])) {
            $jsonStr = is_array($content['values']) ? ($content['values']['en'] ?? '[]') : $content['values'];
            $content['values'] = json_decode($jsonStr, true);
        }

        if (isset($content['milestones'])) {
            $jsonStr = is_array($content['milestones']) ? ($content['milestones']['en'] ?? '[]') : $content['milestones'];
            $content['milestones'] = json_decode($jsonStr, true);
        }

        if (isset($content['members'])) {
            $jsonStr = is_array($content['members']) ? ($content['members']['en'] ?? '[]') : $content['members'];
            $content['members'] = json_decode($jsonStr, true);
        }

        if (isset($content['featured_services'])) {
            $jsonStr = is_array($content['featured_services']) ? ($content['featured_services']['en'] ?? '[]') : $content['featured_services'];
            $content['featured_services'] = json_decode($jsonStr, true);
        }
        
        if (isset($content['featured_projects'])) {
            $jsonStr = is_array($content['featured_projects']) ? ($content['featured_projects']['en'] ?? '[]') : $content['featured_projects'];
            $content['featured_projects'] = json_decode($jsonStr, true);
        }
        
        return $content;
    }

    /**
     * Administration: Handle section content update including files and purification.
     */
    public function updateSection(Section $section, array $validatedData, $request): void
    {
        $type = $section->type;

        // Handle activity toggle if provided
        if ($request->has('is_active_toggle')) {
            $section->is_active = $request->boolean('is_active');
            $section->save();
        }

        // Remove is_active from validatedData so it doesn't create a ContentBlock
        unset($validatedData['is_active']);

        // Filter out items in arrays that don't have IDs (like empty featured picks)
        foreach (['featured_services', 'featured_projects'] as $arrKey) {
            if (isset($validatedData[$arrKey]) && is_array($validatedData[$arrKey])) {
                $validatedData[$arrKey] = collect($validatedData[$arrKey])
                    ->filter(fn($item) => !empty($item['id']))
                    ->values()
                    ->toArray();
            }
        }

        // Handle Files
        $uploadService = app(CloudinaryUploadService::class);
        $imageFields = $this->validationRules->getImageFields($type);
        foreach ($imageFields as $field => $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $validatedData[$field] = $uploadService->upload($file, 'content');
            } else {
                // Keep existing if not provided
                $existing = $section->contentBlocks()->where('key', $field)->value('content');
                if ($existing) {
                    $validatedData[$field] = $existing;
                }
            }
            unset($validatedData[$fileField]);
        }

        // Handle Array-based Files (like team members)
        if (isset($validatedData['members']) && $request->hasFile('members')) {
            foreach ($request->file('members') as $index => $fileData) {
                if (isset($fileData['image_file'])) {
                    $file = $fileData['image_file'];
                    $validatedData['members'][$index]['image'] = resolve_image_url($uploadService->upload($file, 'content/members'));
                }
            }
        }

        // Persist blocks
        foreach ($validatedData as $key => $value) {
            if (is_array($value)) {
                if (isset($value['en'])) {
                    // Translatable field
                    $value = array_map(function($trans) {
                        return function_exists('purify_html') ? purify_html((string)$trans) : $trans;
                    }, $value);
                } else {
                    // Structural array
                    $value = ['en' => json_encode($value)];
                }
            } else {
                $value = function_exists('purify_html') ? purify_html((string)$value) : $value;
            }
            
            $section->contentBlocks()->updateOrCreate(
                ['key' => $key],
                ['content' => $value]
            );
        }

        $this->invalidateSectionCaches($section);
    }

    /**
     * Administration: Update a specific item in a JSON list (e.g., a single team member).
     */
    public function updateSectionItem(Section $section, string $key, int $index, array $itemData, $request): array
    {
        $block = $section->contentBlocks()->where('key', $key)->first();
        $items = $block ? json_decode($block->content, true) : [];
        if (!is_array($items)) $items = [];

        // Update item data from provided array
        if (!isset($items[$index])) {
            $items[$index] = [];
        }

        // Handle File Upload for this item
        if ($request->hasFile("item_file")) {
            $file = $request->file("item_file");
            $uploadService = app(CloudinaryUploadService::class);
            $itemData['image'] = $uploadService->upload($file, 'content');
        }

        $items[$index] = array_merge($items[$index], $itemData);

        // Sanitize and Save
        $jsonContent = json_encode($items);
        $section->contentBlocks()->updateOrCreate(
            ['key' => $key],
            ['content' => $jsonContent]
        );

        $this->invalidateSectionCaches($section);

        return $items[$index];
    }

    /** Clear every response cache affected by a CMS section mutation. */
    public function invalidateSectionCaches(Section $section): void
    {
        $pageSlug = $section->page?->slug;
        $locales = config('app.available_locales', ['en', 'fr', 'ar']);

        if ($pageSlug) {
            cache()->forget("cms_page_{$pageSlug}"); // legacy key
            cache()->forget("cms_page_{$pageSlug}_loc"); // legacy key
            foreach ($locales as $locale) {
                cache()->forget("cms_page_{$pageSlug}_{$locale}");
            }
        }

        if ($pageSlug === 'home') {
            cache()->forget('api_home_data');
        }

        if (in_array($section->type, ['site-info', 'footer-content', 'global-navigation', 'theme-settings'], true)) {
            cache()->forget('site_info');
            cache()->forget('api_global_data'); // legacy key
            foreach ($locales as $locale) {
                cache()->forget("api_global_data_{$locale}");
            }
        }
    }

    private function parseType(string $type): array
    {
        if ($type === 'projects-list') {
            return ['home', 'projects-list'];
        }
        if (str_starts_with($type, 'projects-')) {
            return ['projects', str_replace('projects-', '', $type)];
        }
        if ($type === 'services-list') {
            return ['home', 'services-list'];
        }
        if (str_starts_with($type, 'services-')) {
            return ['services', str_replace('services-', '', $type)];
        }
        if (str_starts_with($type, 'home-')) {
            return ['home', str_replace('home-', '', $type)];
        }
        if (str_starts_with($type, 'about-')) {
            return ['about', str_replace('about-', '', $type)];
        }
        if (str_starts_with($type, 'contact-')) {
            return ['contact', str_replace('contact-', '', $type)];
        }
        return ['home', $type];
    }
}
