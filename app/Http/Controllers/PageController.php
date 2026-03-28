<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Contact;
use App\Models\Page;
use App\Models\Project;
use App\Models\Review;
use App\Models\Service;
use App\Models\Slider;
use App\Models\TcRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        // Default / Fallback Data (prevent 500 error if DB is empty)
        $data = [
            'heroTitle' => 'IT Services & & Technology Solutions',
            'heroSubtitle' => 'GET IT SOLUTIONS',
            'heroButtonText' => 'Explore More',
            'heroImage' => 'assets/img/hero/hero-3.jpg',
            'heroFeatures' => [], // Fallback empty
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
            ]
        ];
        
        $about = new \stdClass();
        $about->title = 'We Deal With The Aspects Of Professional IT Services';
        $about->subtitle = 'About Nova Agency';
        $about->description = 'We provide best IT solutions for your business.';
        $about->image = 'assets/img/about/about-5.png';
        $about->meta_data = ['features' => []];

        $sliders = []; 
        
        // Fetch CMS Data
        $page = Page::with(['sections' => function ($query) {
            $query->where('is_active', true)->orderBy('order_index');
        }, 'sections.contentBlocks'])->where('slug', 'home')->first();

        if ($page) {
             $sections = $page->sections;

            // Extract content for specific sections to populate legacy variables
            foreach ($sections as $section) {
                // Support for new Admin Panel Content Types
                if ($section->type === 'home-hero') {
                    $data['heroTitle'] = $section->getContent('hero_title') ?: $data['heroTitle'];
                    $data['heroSubtitle'] = $section->getContent('hero_subtitle') ?: $data['heroSubtitle'];
                    $data['heroButtonText'] = $section->getContent('hero_button_text') ?: $data['heroButtonText'];
                    $img = $section->getContent('hero_image');
                    if ($img) $data['heroImage'] = $img;
                }
                if ($section->type === 'home-about') {
                    $about->title = $section->getContent('about_title') ?: $about->title;
                    $about->subtitle = $section->getContent('about_subtitle') ?: $about->subtitle;
                    $about->description = $section->getContent('about_description') ?: $about->description;
                    $img = $section->getContent('about_image');
                    if ($img) $about->image = $img;
                    
                    $featuresJson = $section->getContent('features');
                    if ($featuresJson) {
                        $about->meta_data['features'] = json_decode($featuresJson, true);
                    }
                }
                
                // Legacy Support
                if ($section->type === 'hero-3') {
                    $val = $section->getContent('title');
                    if ($val) $data['heroTitle'] = $val;
                    $val = $section->getContent('subtitle');
                    if ($val) $data['heroSubtitle'] = $val;
                    $val = $section->getContent('features');
                    if ($val) $data['heroFeatures'] = json_decode($val, true);
                }
                if ($section->type === 'about-3') {
                    $val = $section->getContent('title');
                    if ($val) $about->title = $val;
                    $val = $section->getContent('subtitle');
                    if ($val) $about->subtitle = $val;
                    $val = $section->getContent('description');
                    if ($val) $about->description = $val;
                    $val = $section->getContent('image');
                    if ($val) $about->image = $val;
                    $val = $section->getContent('features');
                    if ($val) $about->meta_data['features'] = json_decode($val, true);
                }
                if ($section->type === 'services-list') {
                    $val = $section->getContent('title');
                    if ($val) $data['services_title'] = $val;
                    $val = $section->getContent('subtitle');
                    if ($val) $data['services_subtitle'] = $val;
                }
                if ($section->type === 'projects-list') {
                    $val = $section->getContent('title');
                    if ($val) $data['projects_title'] = $val;
                    $val = $section->getContent('subtitle');
                    if ($val) $data['projects_subtitle'] = $val;
                }
                if ($section->type === 'reviews-list') {
                    $val = $section->getContent('title');
                    if ($val) $data['reviews_title'] = $val;
                    $val = $section->getContent('subtitle');
                    if ($val) $data['reviews_subtitle'] = $val;
                }
                if ($section->type === 'blog-list') {
                    $val = $section->getContent('title');
                    if ($val) $data['blog_title'] = $val;
                    $val = $section->getContent('subtitle');
                    if ($val) $data['blog_subtitle'] = $val;
                }
                if ($section->type === 'cta-simple') {
                    $val = $section->getContent('title');
                    if ($val) $data['cta']['title'] = $val;
                    $val = $section->getContent('subtitle');
                    if ($val) $data['cta']['subtitle'] = $val;
                    $val = $section->getContent('description');
                    if ($val) $data['cta']['description'] = $val;
                    $val = $section->getContent('button_text');
                    if ($val) $data['cta']['button_text'] = $val;
                }
            }
        }

        // Fetch dynamic content
        $services = Service::where('is_active', true)->orderBy('order_index')->get();
        $projects = Project::where('is_active', true)->orderBy('order_index')->take(6)->get();
        $reviews = Review::where('is_active', true)->orderBy('order_index')->get();
        $blogs = Blog::where('is_active', true)->whereNotNull('published_at')->orderBy('published_at', 'desc')->take(3)->get();
        $sliders = Slider::where('is_active', true)->orderBy('sort_order')->get();

        return view('index', compact('page', 'data', 'sliders', 'services', 'projects', 'reviews', 'blogs', 'about'));
    }

    public function about(): View
    {
        $pageModel = Page::with(['sections.contentBlocks'])->where('slug', 'about')->first();
        
        // Default structure if DB is empty
        $page = new \stdClass();
        $page->title = 'Deliver unforgettable customer experiences'; 
        $page->subtitle = 'Why Nova Agency';
        $page->description = '';
        $page->content = '';
        $page->image = '';
        $page->meta_data = ['features' => []];

        if ($pageModel) {
             // Find the main content section
             $section = $pageModel->sections->where('type', 'about-main')->first();
             if ($section) {
                 $page->title = $section->getContent('about_title') ?: $page->title;
                 $page->subtitle = $section->getContent('about_subtitle') ?: $page->subtitle;
                 $page->description = $section->getContent('about_description') ?: $page->description;
                 $page->content = $section->getContent('about_content') ?: $page->content;
                 $page->image = $section->getContent('about_image') ?: $page->image;
                 
                 $featuresJson = $section->getContent('features');
                 if ($featuresJson) {
                     $page->meta_data['features'] = json_decode($featuresJson, true);
                 }
             }
        }

        return view('about', compact('page'));
    }

    public function services(): View
    {
        $services = Service::where('is_active', true)->orderBy('order_index')->get();

        // CMS Integration
        $pageModel = Page::with(['sections.contentBlocks'])->where('slug', 'services')->first();
        $page = new \stdClass();
        $page->title = 'Our Services';
        $page->breadcrumb_title = 'Our <span>Services</span>'; // Default with HTML
        $page->image = 'assets/img/breadcrumb-bg.jpg';

        if ($pageModel) {
            // Use Page Model title if specific section not found, stripping HTML tags if needed
            $page->title = $pageModel->title ?: $page->title;
            $page->breadcrumb_title = $pageModel->title ?: $page->breadcrumb_title;

            $section = $pageModel->sections->where('type', 'page-header')->first();
            if ($section) {
                $page->title = $section->getContent('title') ?: $page->title;
                $page->breadcrumb_title = $section->getContent('breadcrumb_title') ?: ($section->getContent('title') ?: $page->breadcrumb_title);
                $img = $section->getContent('image');
                if ($img) $page->image = $img;
            }
        }

        return view('services', compact('services', 'page'));
    }

    public function service($slug): View
    {
         $service = Service::where('slug', $slug)->where('is_active', true)->firstOrFail();
         $allServices = Service::where('is_active', true)->orderBy('order_index')->get();
         return view('service-detail', compact('service', 'allServices'));
    }

    public function projects(): View
    {
        $projects = Project::where('is_active', true)->orderBy('order_index')->get();

        // CMS Integration
        $pageModel = Page::with(['sections.contentBlocks'])->where('slug', 'projects')->first();
        $page = new \stdClass();
        $page->title = 'Our Projects';
        $page->breadcrumb_title = 'Our <span>Projects</span>';
        $page->image = 'assets/img/breadcrumb-bg.jpg';

        if ($pageModel) {
            $page->title = $pageModel->title ?: $page->title;
            $page->breadcrumb_title = $pageModel->title ?: $page->breadcrumb_title;

            $section = $pageModel->sections->where('type', 'page-header')->first();
            if ($section) {
                $page->title = $section->getContent('title') ?: $page->title;
                $page->breadcrumb_title = $section->getContent('breadcrumb_title') ?: ($section->getContent('title') ?: $page->breadcrumb_title);
                $img = $section->getContent('image');
                if ($img) $page->image = $img;
            }
        }

        return view('projects', compact('projects', 'page'));
    }

    public function project($slug): View
    {
         $project = Project::where('slug', $slug)->where('is_active', true)->firstOrFail();
         $relatedProjects = Project::where('is_active', true)->where('id', '!=', $project->id)->inRandomOrder()->take(3)->get();
         return view('project-detail', compact('project', 'relatedProjects'));
    }

    public function blog(): View
    {
        $blogs = Blog::where('is_active', true)->whereNotNull('published_at')->orderBy('published_at', 'desc')->paginate(6);
        $recentBlogs = Blog::where('is_active', true)->whereNotNull('published_at')->orderBy('published_at', 'desc')->take(3)->get();

        // CMS Integration
        $pageModel = Page::with(['sections.contentBlocks'])->where('slug', 'blog')->first();
        $page = new \stdClass();
        $page->title = 'Our Blog';
        $page->breadcrumb_title = 'Latest <span>News</span>';
        $page->image = 'assets/img/breadcrumb-bg.jpg';

        if ($pageModel) {
            $page->title = $pageModel->title ?: $page->title;
            $page->breadcrumb_title = $pageModel->title ?: $page->breadcrumb_title;

            $section = $pageModel->sections->where('type', 'page-header')->first();
            if ($section) {
                $page->title = $section->getContent('title') ?: $page->title;
                $page->breadcrumb_title = $section->getContent('breadcrumb_title') ?: ($section->getContent('title') ?: $page->breadcrumb_title);
                $img = $section->getContent('image');
                if ($img) $page->image = $img;
            }
        }

        return view('blog', compact('blogs', 'recentBlogs', 'page'));
    }

    public function blogPost($slug): View
    {
        $blog = Blog::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $recentBlogs = Blog::where('is_active', true)->whereNotNull('published_at')->where('id', '!=', $blog->id)->orderBy('published_at', 'desc')->take(3)->get();
        return view('blog-detail', compact('blog', 'recentBlogs'));
    }

    public function contact(): View
    {
        $pageModel = Page::with(['sections.contentBlocks'])->where('slug', 'contact')->first();
        
        $page = new \stdClass();
        $page->contact_address = '123 Business Street, City, State 12345';
        $page->contact_email = 'test@gmail.com';
        $page->contact_phone = '+1 (555) 123-4567';
        
        if ($pageModel) {
            $section = $pageModel->sections->where('type', 'contact-info')->first();
            if ($section) {
                $page->contact_address = $section->getContent('contact_address') ?: $page->contact_address;
                $page->contact_email = $section->getContent('contact_email') ?: $page->contact_email;
                $page->contact_phone = $section->getContent('contact_phone') ?: $page->contact_phone;
            }
        }
        
        $services = Service::where('is_active', true)->orderBy('order_index')->get();
        
        return view('contact', compact('page', 'services'));
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        Contact::create($validated);

        return back()->with('success', 'Thank you for contacting us! We will get back to you shortly.');
    }

    public function tcRequestSubmit(\App\Http\Requests\TcRequestSubmitRequest $request)
    {
        $validated = $request->validated();

        $path = null;
        if ($request->hasFile('attached_file')) {
            $path = $request->file('attached_file')->store('tc-requests', 'public');
        }

        TcRequest::create([
            'email' => $validated['email'],
            'description' => $validated['description'],
            'attached_file' => $path,
            'service_id' => $validated['service_id'] ?? null,
        ]);

        return back()->with('success', 'Your request has been received. Our team will review it shortly.');
    }
}
