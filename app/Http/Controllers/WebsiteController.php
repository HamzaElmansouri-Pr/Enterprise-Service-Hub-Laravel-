<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Project;
use App\Models\Review;
use App\Models\Blog;
use App\Models\Slider;
use App\Models\Partner;
use App\Models\Section;
use App\Services\CMSManager;
use Illuminate\View\View;

class WebsiteController extends Controller
{
    protected CMSManager $cmsManager;

    public function __construct(CMSManager $cmsManager)
    {
        $this->cmsManager = $cmsManager;
    }

    /**
     * Display the home page.
     */
    public function home(): View
    {
        $cms = $this->cmsManager->resolvePage('home', [
            'heroTitle' => 'IT Services & Technology Solutions',
            'heroSubtitle' => 'GET IT SOLUTIONS',
            'heroButtonText' => 'Explore More',
            'heroImage' => 'assets/img/hero/hero-3.jpg',
            'services_title' => 'Our Awesome Services',
            'services_subtitle' => 'What We Do',
            'projects_title' => 'Our Recent Projects', 
            'projects_subtitle' => 'Case Studies',
            'reviews_title' => 'Customer Feedback',
            'reviews_subtitle' => 'Testimonials',
            'blog_title' => 'Direct from the Blog',
            'blog_subtitle' => 'Latest News',
            'cta' => [
                'title' => 'Stay Connected With Nova Agency',
                'subtitle' => 'Contact Us',
                'description' => 'Get in touch for professional IT solutions.',
                'button_text' => 'Contact Us Now'
            ],
            'about' => [
                'title' => 'We Deal With The Aspects Of Professional IT Services',
                'subtitle' => 'About Nova Agency',
                'description' => 'We provide best IT solutions for your business.',
                'image' => 'assets/img/about/about-5.png',
                'meta_data' => ['features' => []]
            ]
        ]);

        $page = $cms->model;
        $data = (array) $cms;
        $about = $cms->about;

        // Dynamic content
        $featuredConfig = $cms->featured_services ?? [];
        if (!empty($featuredConfig)) {
            $featuredIds = collect($featuredConfig)->pluck('id')->toArray();
            $services = Service::whereIn('id', $featuredIds)
                ->where('is_active', true)
                ->get()
                ->sortBy(function($service) use ($featuredConfig) {
                    $config = collect($featuredConfig)->firstWhere('id', $service->id);
                    return $config['order'] ?? 0;
                });
        } else {
            $services = Service::where('is_active', true)->orderBy('order_index')->get();
        }
        
        $featuredProjConfig = $cms->featured_projects ?? [];
        if (!empty($featuredProjConfig)) {
            $featuredProjIds = collect($featuredProjConfig)->pluck('id')->toArray();
            $projects = \App\Models\Project::whereIn('id', $featuredProjIds)
                ->where('is_active', true)
                ->get()
                ->sortBy(function($project) use ($featuredProjConfig) {
                    $config = collect($featuredProjConfig)->firstWhere('id', $project->id);
                    return $config['order'] ?? 0;
                });
        } else {
            $projects = Project::where('is_active', true)->orderBy('order_index')->take(6)->get();
        }

        $reviews = Review::where('is_active', true)->orderBy('order_index')->get();
        $blogs = Blog::active()->with('author')->orderBy('published_at', 'desc')->take(3)->get();
        $sliders = Slider::where('is_active', true)->orderBy('sort_order')->get();
        
        // Fetch specific sections for visibility checks
        $heroSection = Section::where('type', 'home-hero')->first();
        $aboutSection = Section::where('type', 'home-about')->first();
        $servicesSection = Section::where('type', 'services-list')->first();
        $projectsSection = Section::where('type', 'projects-list')->first();
        $reviewsSection = Section::where('type', 'reviews-list')->first();
        $blogSection = Section::where('type', 'blog-list')->first();
        $ctaSection = Section::where('type', 'cta-simple')->first();
        $partnersSection = Section::where('type', 'home-partners')->first();

        $partners = ($partnersSection && $partnersSection->is_active) 
            ? Partner::where('is_active', true)->orderBy('order_index')->get() 
            : collect();

        return view('index', compact(
            'cms', 'page', 'data', 'sliders', 'services', 'projects', 'reviews', 'blogs', 'about', 'partners', 
            'heroSection', 'aboutSection', 'servicesSection', 'projectsSection', 'reviewsSection', 'blogSection', 'ctaSection', 'partnersSection'
        ));
    }

    /**
     * Display the about page.
     */
    public function about(): View
    {
        $page = $this->cmsManager->resolvePage('about', [
            'breadcrumb_title' => 'About <span>Us</span>',
            'image' => 'assets/img/breadcrumb-bg.jpg',
            'about' => null,
            'stats' => null,
            'values' => null,
            'history' => null,
            'team' => null,
        ]);

        return view('about', compact('page'));
    }
}
