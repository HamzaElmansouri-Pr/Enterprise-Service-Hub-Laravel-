<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Page;
use App\Models\Section;
use stdClass;
use Illuminate\Support\Collection;

class CMSPageResolver
{
    public function resolvePage(string $slug, array $fallbacks = [], bool $localize = false): stdClass
    {
        // Localized content must not share a cache entry between languages.
        $cacheKey = "cms_page_{$slug}" . ($localize ? '_' . app()->getLocale() : '');
        
        return cache()->remember($cacheKey, now()->addMinutes(60), function () use ($slug, $fallbacks, $localize) {
            $pageModel = Page::with(['sections' => function ($query) {
                $query->where('is_active', true)->orderBy('order_index');
            }, 'sections.contentBlocks'])->where('slug', $slug)->first();

            $data = new stdClass();
            $data->model = $pageModel;

            // Apply fallbacks
            foreach ($fallbacks as $key => $value) {
                if (is_array($value)) {
                    // Resolve images in nested fallback arrays (like 'about' => ['image' => '...'])
                    foreach ($value as $subKey => &$subValue) {
                        if (($subKey === 'image' || str_ends_with($subKey, 'Image')) && is_string($subValue)) {
                            $subValue = resolve_image_url($subValue);
                        }
                    }
                    $data->$key = (object) $value;
                } else {
                    // Resolve direct fallback images
                    if (($key === 'image' || str_ends_with($key, 'Image')) && is_string($value)) {
                        $value = resolve_image_url($value);
                    }
                    $data->$key = $value;
                }
            }

            if (!$pageModel) {
                return $data;
            }

            // Map each section
            foreach ($pageModel->sections as $section) {
                $this->mapSection($section, $data);
            }

            return $data;
        });
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
            case 'blog-page-header':
            case 'contact-page-header':
                $data->title = $section->getContent('title') ?: ($data->title ?? '');
                $data->breadcrumb_title = $section->getContent('breadcrumb_title') ?: ($section->getContent('title') ?: ($data->breadcrumb_title ?? ''));
                $img = $section->getContent('image');
                if ($img) $data->image = resolve_image_url($img);
                break;

            case 'contact-info':
                $data->contact_title = $section->getContent('contact_title') ?: ($data->contact_title ?? '');
                $data->contact_description = $section->getContent('contact_description') ?: ($data->contact_description ?? '');
                $data->contact_address = $section->getContent('contact_address') ?: ($data->contact_address ?? '');
                $data->contact_email = $section->getContent('contact_email') ?: ($data->contact_email ?? '');
                $data->contact_phone = $section->getContent('contact_phone') ?: ($data->contact_phone ?? '');
                $logo = $section->getContent('contact_logo');
                if ($logo) $data->contact_logo = resolve_image_url($logo);
                break;

            case 'cta-simple':
                $data->cta = $data->cta ?? new stdClass();
                $data->cta->title = $section->getContent('title') ?: ($data->cta->title ?? '');
                $data->cta->subtitle = $section->getContent('subtitle') ?: ($data->cta->subtitle ?? '');
                $data->cta->description = $section->getContent('description') ?: ($data->cta->description ?? '');
                $data->cta->button_text = $section->getContent('button_text') ?: ($data->cta->button_text ?? '');
                $data->cta->button_url = $section->getContent('button_url') ?: ($data->cta->button_url ?? '/contact');
                $data->cta->eyebrow = $section->getContent('eyebrow') ?: ($data->cta->eyebrow ?? '');
                $data->cta->visual_variant = $section->getContent('visual_variant') ?: ($data->cta->visual_variant ?? 'primary');
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
                $data->reviews_eyebrow = $section->getContent('eyebrow') ?: ($data->reviews_eyebrow ?? '');
                break;

            case 'blog-list':
                $data->blog_title = $section->getContent('title') ?: ($data->blog_title ?? '');
                $data->blog_subtitle = $section->getContent('subtitle') ?: ($data->blog_subtitle ?? '');
                $data->blog_eyebrow = $section->getContent('eyebrow') ?: ($data->blog_eyebrow ?? '');
                $data->blog_button_text = $section->getContent('button_text') ?: ($data->blog_button_text ?? '');
                $data->blog_button_url = $section->getContent('button_url') ?: ($data->blog_button_url ?? '');
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

            case 'home-partners':
                $data->partners = (object) [
                    'eyebrow' => $section->getContent('eyebrow'),
                    'title' => $section->getContent('partners_title'),
                    'subtitle' => $section->getContent('partners_subtitle'),
                ];
                break;
        }
    }

    protected function mapHeroSection(Section $section, stdClass $data): void
    {
        $data->heroTitle = $section->getContent('hero_title') ?: ($section->getContent('title') ?: ($data->heroTitle ?? ''));
        $data->heroSubtitle = $section->getContent('hero_subtitle') ?: ($section->getContent('subtitle') ?: ($data->heroSubtitle ?? ''));
        $data->heroButtonText = $section->getContent('hero_button_text') ?: ($data->heroButtonText ?? '');
        
        $img = $section->getContent('hero_image') ?: $section->getContent('image');
        if ($img) $data->heroImage = resolve_image_url($img);

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
        $data->about->eyebrow = $section->getContent('eyebrow') ?: ($data->about->eyebrow ?? '');
        $data->about->highlight_value = $section->getContent('highlight_value') ?: ($data->about->highlight_value ?? '');
        $data->about->highlight_suffix = $section->getContent('highlight_suffix') ?: ($data->about->highlight_suffix ?? '');
        $data->about->highlight_label = $section->getContent('highlight_label') ?: ($data->about->highlight_label ?? '');
        $data->about->button_text = $section->getContent('button_text') ?: ($data->about->button_text ?? '');
        $data->about->button_url = $section->getContent('button_url') ?: ($data->about->button_url ?? '');
        
        $img = $section->getContent('about_image') ?: $section->getContent('image');
        if ($img) $data->about->image = resolve_image_url($img);
        
        $headerImg = $section->getContent('header_image');
        if ($headerImg) $data->image = resolve_image_url($headerImg);
        
        $featuresJson = $section->getContent('features');
        if ($featuresJson) {
            $features = json_decode($featuresJson, true);
            foreach ($features as &$feature) {
                if (isset($feature['image'])) {
                    $feature['image'] = resolve_image_url($feature['image']);
                }
            }
            $data->about->meta_data = $data->about->meta_data ?? [];
            $data->about->meta_data['features'] = $features;
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
            $members = json_decode($teamJson, true);
            foreach ($members as &$member) {
                if (isset($member['image'])) {
                    $member['image'] = resolve_image_url($member['image']);
                }
            }
            $data->team->members = $members;
        }
    }

    protected function mapProjectsSection(Section $section, stdClass $data): void
    {
        $data->projects_title = $section->getContent('title');
        $data->projects_subtitle = $section->getContent('subtitle');
        $data->projects_eyebrow = $section->getContent('eyebrow');
        $data->projects_button_text = $section->getContent('button_text');
        $data->projects_button_url = $section->getContent('button_url');
        $featuredJson = $section->getContent('featured_projects');
        if ($featuredJson) {
            $data->featured_projects = json_decode($featuredJson, true);
        }
    }

    protected function mapServicesSection(Section $section, stdClass $data): void
    {
        $data->services_title = $section->getContent('title');
        $data->services_subtitle = $section->getContent('subtitle');
        $data->services_eyebrow = $section->getContent('eyebrow');
        $data->services_button_text = $section->getContent('button_text');
        $data->services_button_url = $section->getContent('button_url');
        $featuredJson = $section->getContent('featured_services');
        if ($featuredJson) {
            $data->featured_services = json_decode($featuredJson, true);
        }
    }
}
