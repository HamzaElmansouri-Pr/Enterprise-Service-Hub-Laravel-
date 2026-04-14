<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Section;
use stdClass;
use Illuminate\Support\Collection;

class CMSManager
{
    /**
     * Resolve a page and its segments into a structured data object.
     * 
     * @param string $slug
     * @param array $fallbacks
     * @return stdClass
     */
    public function resolvePage(string $slug, array $fallbacks = []): stdClass
    {
        $pageModel = Page::with(['sections' => function ($query) {
            $query->where('is_active', true)->orderBy('order_index');
        }, 'sections.contentBlocks'])->where('slug', $slug)->first();

        $data = new stdClass();
        $data->model = $pageModel;

        // Apply fallbacks
        foreach ($fallbacks as $key => $value) {
            $data->$key = is_array($value) ? (object) $value : $value;
        }

        if (!$pageModel) {
            return $data;
        }

        // Map each section
        foreach ($pageModel->sections as $section) {
            $this->mapSection($section, $data);
        }

        return $data;
    }

    /**
     * Centralized logic to map section content to unified data properties.
     */
    protected function mapSection(Section $section, stdClass $data): void
    {
        $type = $section->type;

        switch ($type) {
            case 'home-hero':
            case 'hero-3':
                $this->mapHeroSection($section, $data);
                break;

            case 'home-about':
            case 'about-main':
            case 'about-3':
                $this->mapAboutSection($section, $data);
                break;

            case 'page-header':
            case 'projects-page-header':
            case 'services-page-header':
                $data->title = $section->getContent('title') ?: ($data->title ?? '');
                $data->breadcrumb_title = $section->getContent('breadcrumb_title') ?: ($section->getContent('title') ?: ($data->breadcrumb_title ?? ''));
                $img = $section->getContent('image');
                if ($img) $data->image = $img;
                break;

            case 'contact-info':
                $data->contact_address = $section->getContent('contact_address') ?: ($data->contact_address ?? '');
                $data->contact_email = $section->getContent('contact_email') ?: ($data->contact_email ?? '');
                $data->contact_phone = $section->getContent('contact_phone') ?: ($data->contact_phone ?? '');
                break;

            case 'cta-simple':
                $data->cta = $data->cta ?? new stdClass();
                $data->cta->title = $section->getContent('title') ?: ($data->cta->title ?? '');
                $data->cta->subtitle = $section->getContent('subtitle') ?: ($data->cta->subtitle ?? '');
                $data->cta->description = $section->getContent('description') ?: ($data->cta->description ?? '');
                $data->cta->button_text = $section->getContent('button_text') ?: ($data->cta->button_text ?? '');
                break;

            case 'services-list':
                $this->mapServicesSection($section, $data);
                break;

            case 'projects-list':
                $this->mapProjectsSection($section, $data);
                break;

            case 'reviews-list':
                $data->reviews_title = $section->getContent('title') ?: ($data->reviews_title ?? '');
                $data->reviews_subtitle = $section->getContent('subtitle') ?: ($data->reviews_subtitle ?? '');
                break;

            case 'blog-list':
                $data->blog_title = $section->getContent('title') ?: ($data->blog_title ?? '');
                $data->blog_subtitle = $section->getContent('subtitle') ?: ($data->blog_subtitle ?? '');
                break;

            case 'about-stats':
                $this->mapStatsSection($section, $data);
                break;

            case 'about-values':
                $this->mapValuesSection($section, $data);
                break;

            case 'about-history':
                $this->mapHistorySection($section, $data);
                break;

            case 'about-team':
                $this->mapTeamSection($section, $data);
                break;
        }
    }

    protected function mapHeroSection(Section $section, stdClass $data): void
    {
        $data->heroTitle = $section->getContent('hero_title') ?: ($section->getContent('title') ?: ($data->heroTitle ?? ''));
        $data->heroSubtitle = $section->getContent('hero_subtitle') ?: ($section->getContent('subtitle') ?: ($data->heroSubtitle ?? ''));
        $data->heroButtonText = $section->getContent('hero_button_text') ?: ($data->heroButtonText ?? '');
        
        $img = $section->getContent('hero_image') ?: $section->getContent('image');
        if ($img) $data->heroImage = $img;

        $features = $section->getContent('features');
        if ($features) {
            $data->heroFeatures = json_decode($features, true);
        }
    }

    protected function mapAboutSection(Section $section, stdClass $data): void
    {
        $data->about = $data->about ?? new stdClass();
        $data->about->title = $section->getContent('about_title') ?: ($section->getContent('title') ?: ($data->about->title ?? ''));
        $data->about->subtitle = $section->getContent('about_subtitle') ?: ($section->getContent('subtitle') ?: ($data->about->subtitle ?? ''));
        $data->about->description = $section->getContent('about_description') ?: ($section->getContent('description') ?: ($data->about->description ?? ''));
        $data->about->content = $section->getContent('about_content') ?: ($section->getContent('content') ?: ($data->about->content ?? ''));
        
        $img = $section->getContent('about_image') ?: $section->getContent('image');
        if ($img) $data->about->image = $img;
        
        $featuresJson = $section->getContent('features');
        if ($featuresJson) {
            $data->about->meta_data = $data->about->meta_data ?? [];
            $data->about->meta_data['features'] = json_decode($featuresJson, true);
        }
    }

    protected function mapStatsSection(Section $section, stdClass $data): void
    {
        $data->stats = new stdClass();
        $data->stats->title = $section->getContent('stats_title');
        $data->stats->subtitle = $section->getContent('stats_subtitle');
        $statsJson = $section->getContent('stats');
        if ($statsJson) {
            $data->stats->items = json_decode($statsJson, true);
        }
    }

    protected function mapValuesSection(Section $section, stdClass $data): void
    {
        $data->values = new stdClass();
        $data->values->title = $section->getContent('values_title');
        $data->values->subtitle = $section->getContent('values_subtitle');
        $valuesJson = $section->getContent('values');
        if ($valuesJson) {
            $data->values->items = json_decode($valuesJson, true);
        }
    }

    protected function mapHistorySection(Section $section, stdClass $data): void
    {
        $data->history = new stdClass();
        $data->history->title = $section->getContent('history_title');
        $data->history->subtitle = $section->getContent('history_subtitle');
        $historyJson = $section->getContent('milestones');
        if ($historyJson) {
            $data->history->milestones = json_decode($historyJson, true);
        }
    }

    protected function mapTeamSection(Section $section, stdClass $data): void
    {
        $data->team = new stdClass();
        $data->team->title = $section->getContent('team_title');
        $data->team->subtitle = $section->getContent('team_subtitle');
        $teamJson = $section->getContent('members');
        if ($teamJson) {
            $data->team->members = json_decode($teamJson, true);
        }
    }

    protected function mapProjectsSection(Section $section, stdClass $data): void
    {
        $data->projects_title = $section->getContent('title');
        $data->projects_subtitle = $section->getContent('subtitle');
        $featuredJson = $section->getContent('featured_projects');
        if ($featuredJson) {
            $data->featured_projects = json_decode($featuredJson, true);
        }
    }

    protected function mapServicesSection(Section $section, stdClass $data): void
    {
        // Handle title and subtitle if needed (using keys from ContentController)
        $data->services_title = $section->getContent('title');
        $data->services_subtitle = $section->getContent('subtitle');
        $featuredJson = $section->getContent('featured_services');
        if ($featuredJson) {
            $data->featured_services = json_decode($featuredJson, true);
        }
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
        
        return $page->sections()->firstOrCreate(['type' => $type], [
            'name' => ucwords(str_replace('-', ' ', $sectionKey)),
            'is_active' => true,
        ]);
    }

    /**
     * Administration: Get raw content blocks for editing.
     */
    public function getSectionContentBlocks(Section $section): array
    {
        $content = $section->contentBlocks()->pluck('content', 'key')->toArray();
        
        if (isset($content['features'])) {
            $content['features'] = json_decode($content['features'], true);
        }
        
        if (isset($content['stats'])) {
            $content['stats'] = json_decode($content['stats'], true);
        }

        if (isset($content['values'])) {
            $content['values'] = json_decode($content['values'], true);
        }

        if (isset($content['milestones'])) {
            $content['milestones'] = json_decode($content['milestones'], true);
        }

        if (isset($content['members'])) {
            $content['members'] = json_decode($content['members'], true);
        }

        if (isset($content['featured_services'])) {
            $content['featured_services'] = json_decode($content['featured_services'], true);
        }
        
        if (isset($content['featured_projects'])) {
            $content['featured_projects'] = json_decode($content['featured_projects'], true);
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
        $imageFields = $this->getImageFields($type);
        foreach ($imageFields as $field => $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $path = $file->store('uploads/content', 'public');
                $validatedData[$field] = $path;
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
                    $path = $file->store('uploads/content', 'public');
                    $validatedData['members'][$index]['image'] = $path;
                }
            }
        }

        // Persist blocks
        foreach ($validatedData as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            } else {
                $value = function_exists('purify_html') ? purify_html((string)$value) : $value;
            }
            
            $section->contentBlocks()->updateOrCreate(
                ['key' => $key],
                ['content' => $value]
            );
        }

        // Cache busting
        if ($type === 'site-info') {
            cache()->forget('site_info');
        }
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
            $path = $file->store('uploads/content', 'public');
            $itemData['image'] = $path;
        }

        $items[$index] = array_merge($items[$index], $itemData);

        // Sanitize and Save
        $jsonContent = json_encode($items);
        $section->contentBlocks()->updateOrCreate(
            ['key' => $key],
            ['content' => $jsonContent]
        );

        return $items[$index];
    }

    /**
     * Administration: Get validation rules for a section type.
     */
    public function getValidationRules(string $type): array
    {
        if (str_contains($type, 'page-header')) {
            $type = 'page-header';
        }

        $rules = [
            'home-hero' => [
                'hero_title' => 'required|string|max:255',
                'hero_subtitle' => 'required|string|max:500',
                'hero_button_text' => 'required|string|max:50',
                'hero_image' => 'nullable|string',
                'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            'home-features' => [
                'features_title' => 'required|string|max:255',
                'features_subtitle' => 'required|string|max:500',
                'features' => 'required|array|min:1',
                'features.*.title' => 'required|string|max:255',
                'features.*.description' => 'required|string|max:500',
            ],
            'about-main' => [
                'about_title' => 'required|string|max:255',
                'about_subtitle' => 'required|string|max:255',
                'about_description' => 'required|string|max:2000',
                'about_image' => 'nullable|string',
                'about_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'about_content' => 'nullable|string',
                'features' => 'nullable|array',
                'features.*.title' => 'nullable|string|max:255',
                'features.*.description' => 'nullable|string|max:500',
            ],
            'home-about' => [
                'about_title' => 'required|string|max:255',
                'about_subtitle' => 'required|string|max:255',
                'about_description' => 'required|string|max:2000',
                'about_image' => 'nullable|string',
                'about_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'about_content' => 'nullable|string',
                'features' => 'nullable|array',
                'features.*.title' => 'nullable|string|max:255',
                'features.*.description' => 'nullable|string|max:500',
            ],
            'contact-info' => [
                'contact_title' => 'required|string|max:255',
                'contact_description' => 'required|string|max:500',
                'contact_phone' => 'required|string|max:50',
                'contact_email' => 'required|email|max:255',
                'contact_address' => 'required|string|max:500',
                'contact_logo' => 'nullable|string|max:255',
                'contact_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            'home-partners' => [
                'partners_title' => 'nullable|string|max:255',
                'partners_subtitle' => 'nullable|string|max:500',
            ],
            'page-header' => [
                'title' => 'required|string|max:255',
                'breadcrumb_title' => 'required|string|max:500',
                'image' => 'nullable|string',
                'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            'about-stats' => [
                'stats_title' => 'nullable|string|max:255',
                'stats_subtitle' => 'nullable|string|max:500',
                'stats' => 'nullable|array',
                'stats.*.icon' => 'nullable|string|max:100',
                'stats.*.number' => 'nullable|string|max:50',
                'stats.*.suffix' => 'nullable|string|max:20',
                'stats.*.label' => 'nullable|string|max:255',
            ],
            'about-values' => [
                'values_title' => 'nullable|string|max:255',
                'values_subtitle' => 'nullable|string|max:500',
                'values' => 'nullable|array',
                'values.*.icon' => 'nullable|string|max:100',
                'values.*.title' => 'nullable|string|max:255',
                'values.*.description' => 'nullable|string|max:1000',
            ],
            'about-history' => [
                'history_title' => 'nullable|string|max:255',
                'history_subtitle' => 'nullable|string|max:500',
                'milestones' => 'nullable|array',
                'milestones.*.year' => 'nullable|string|max:10',
                'milestones.*.title' => 'nullable|string|max:255',
                'milestones.*.description' => 'nullable|string|max:1000',
            ],
            'about-team' => [
                'team_title' => 'nullable|string|max:255',
                'team_subtitle' => 'nullable|string|max:500',
                'members' => 'nullable|array',
                'members.*.name' => 'nullable|string|max:255',
                'members.*.position' => 'nullable|string|max:255',
                'members.*.image' => 'nullable|string|max:500',
                'members.*.image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'members.*.facebook' => 'nullable|string|max:255',
                'members.*.twitter' => 'nullable|string|max:255',
                'members.*.linkedin' => 'nullable|string|max:255',
            ],
            'services-list' => [
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string|max:500',
                'featured_services' => 'nullable|array',
                'featured_services.*.id' => 'nullable|integer|exists:services,id',
                'featured_services.*.order' => 'nullable|integer|min:0',
            ],
            'projects-list' => [
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:500',
                'featured_projects' => 'nullable|array',
                'featured_projects.*.id' => 'nullable|integer|exists:projects,id',
                'featured_projects.*.order' => 'nullable|integer|min:0',
            ],
            'reviews-list' => [
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:500',
            ],
            'blog-list' => [
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:500',
            ],
            'cta-simple' => [
                'title' => 'required|string|max:255',
                'subtitle' => 'nullable|string|max:500',
                'description' => 'required|string|max:1000',
                'button_text' => 'required|string|max:50',
                'button_url' => 'nullable|string|max:255',
            ],
        ];

        return $rules[$type] ?? [];
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

    private function getImageFields(string $type): array
    {
        if (str_contains($type, 'page-header')) {
            $type = 'page-header';
        }

        $map = [
            'home-hero' => ['hero_image' => 'hero_image_file'],
            'about-main' => ['about_image' => 'about_image_file'],
            'home-about' => ['about_image' => 'about_image_file'],
            'contact-info' => ['contact_logo' => 'contact_logo_file'],
            'page-header' => ['image' => 'image_file'],
            'site-info' => [
                'site_logo' => 'site_logo_file',
                'site_favicon' => 'site_favicon_file'
            ],
        ];
        return $map[$type] ?? [];
    }
}
