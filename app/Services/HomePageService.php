<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Service;
use App\Models\Project;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Section;
use Illuminate\Support\Facades\Cache;

class HomePageService
{
    /**
     * Get optimized home page data.
     * 
     * @param object $cms
     * @return array
     */
    public function getHomeData(object $cms): array
    {
        return Cache::rememberForever('api_home_data', function () use ($cms) {
            // Section visibility
            $sections = Section::whereIn('type', [
                'home-hero', 'home-about', 'services-list', 'projects-list',
                'reviews-list', 'blog-list', 'cta-simple', 'home-partners'
            ])->get()->keyBy('type');

            // Featured services
            $featuredConfig = $cms->featured_services ?? [];
            if (!empty($featuredConfig)) {
                $featuredIds = collect($featuredConfig)->pluck('id')->toArray();
                $services = Service::whereIn('id', $featuredIds)
                    ->where('is_active', true)
                    ->select('id', 'title', 'slug', 'subtitle', 'icon', 'image', 'order_index')
                    ->get()
                    ->sortBy(function ($service) use ($featuredConfig) {
                        $config = collect($featuredConfig)->firstWhere('id', $service->id);
                        return $config['order'] ?? 0;
                    })->values();
            } else {
                $services = Service::where('is_active', true)
                    ->select('id', 'title', 'slug', 'subtitle', 'icon', 'image', 'order_index')
                    ->orderBy('order_index')->take(12)->get();
            }

            // Featured projects
            $featuredProjConfig = $cms->featured_projects ?? [];
            if (!empty($featuredProjConfig)) {
                $featuredProjIds = collect($featuredProjConfig)->pluck('id')->toArray();
                $projects = Project::whereIn('id', $featuredProjIds)
                    ->where('is_active', true)
                    ->select('id', 'title', 'slug', 'category', 'image', 'order_index')
                    ->get()
                    ->sortBy(function ($project) use ($featuredProjConfig) {
                        $config = collect($featuredProjConfig)->firstWhere('id', $project->id);
                        return $config['order'] ?? 0;
                    })->values();
            } else {
                $projects = Project::where('is_active', true)
                    ->select('id', 'title', 'slug', 'category', 'image', 'order_index')
                    ->orderBy('order_index')->take(6)->get();
            }

            $reviews = Review::where('is_active', true)
                ->select('id', 'client_name', 'client_position', 'client_company', 'client_image', 'review_text', 'rating')
                ->orderBy('order_index')->take(10)->get();

            $blogs = Blog::active()->with(['author:id,name,image'])
                ->select('id', 'title', 'slug', 'excerpt', 'image', 'category', 'published_at', 'author_id')
                ->orderBy('published_at', 'desc')->take(3)->get();

            $sliders = Slider::where('is_active', true)->orderBy('sort_order')->get();

            // Partners (only if section is active)
            $partnersSection = $sections->get('home-partners');
            $partners = ($partnersSection && $partnersSection->is_active)
                ? Partner::where('is_active', true)->select('id', 'name', 'logo_url', 'url')->orderBy('order_index')->take(20)->get()
                : collect();

            return [
                'services' => $services,
                'projects' => $projects,
                'reviews'  => $reviews,
                'blogs'    => $blogs,
                'sliders'  => $sliders,
                'partners' => $partners,
                'sections' => $sections->values(),
            ];
        });
    }
}
