<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Review;
use App\Models\Slider;
use App\Models\Contact;
use App\Models\TcRequest;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home()
    {
        $sliders = Slider::active()->ordered()->get();
        // Recent services (3) and recent projects (2)
        $services = Service::active()->orderBy('created_at', 'desc')->take(3)->get();
        $projects = Project::active()->orderBy('created_at', 'desc')->take(2)->get();
        $reviews = Review::approved()->featured()->ordered()->take(6)->get();
        $blogs = Blog::published()->featured()->orderBy('published_at', 'desc')->take(3)->get();
        $about = Page::getByName('about');
        
        $data = [
            'siteDescription' => 'SupremeIT provides cutting-edge technology solutions to help businesses grow and succeed in the digital world.',
            'heroTitle' => 'The Full CRM solution built for your success',
            'heroSubtitle' => 'All your customer data, tools, and insights in one unified platform.',
            'features' => [
                [
                    'title' => 'All-in-One CRM',
                    'description' => 'Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.'
                ],
                [
                    'title' => 'Affordable',
                    'description' => 'Make the most of SupremeIT\'s modern features & integrations, easy implementation and great support at an affordable price.'
                ],
                [
                    'title' => 'Next-Generation',
                    'description' => 'Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.'
                ]
            ],
            'stats' => [
                'customers' => '15,000+',
                'satisfaction' => '92',
                'cost_reduction' => '48'
            ]
        ];

        return view('index', compact('data', 'sliders', 'services', 'projects', 'reviews', 'blogs', 'about'));
    }

    /**
     * Display the about page.
     */
    public function about()
    {
        $page = Page::getByName('about');
        $services = Service::active()->ordered()->get();
        $reviews = Review::approved()->featured()->ordered()->take(6)->get();
        
        $data = [
            'siteDescription' => 'SupremeIT provides cutting-edge technology solutions to help businesses grow and succeed in the digital world.',
            'pageTitle' => 'About Us',
            'breadcrumb' => [
                ['name' => 'Home', 'url' => route('home')],
                ['name' => 'About Us', 'url' => route('about')]
            ],
            'features' => [
                [
                    'title' => 'All-in-One CRM',
                    'description' => 'Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.'
                ],
                [
                    'title' => 'Affordable',
                    'description' => 'Make the most of SupremeIT\'s modern features & integrations, easy implementation and great support at an affordable price.'
                ],
                [
                    'title' => 'Next-Generation',
                    'description' => 'Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.'
                ]
            ],
            'stats' => [
                'customers' => '20,000+',
                'satisfaction' => '92',
                'cost_reduction' => '48'
            ]
        ];

        return view('about', compact('data', 'page', 'services', 'reviews'));
    }

    /**
     * Display the services page.
     */
    public function services()
    {
        $page = Page::getByName('services');
        $services = Service::active()->ordered()->get();
        
        return view('services', compact('page', 'services'));
    }

    /**
     * Display a specific service.
     */
    public function service(Service $service)
    {
       
            
        return view('service-detail', compact('service',));
    }

    /**
     * Display the projects page.
     */
    public function projects()
    {
        $page = Page::getByName('projects');
        $projects = Project::active()->ordered()->get();
        $categories = Project::active()->distinct()->pluck('category')->filter();
        
        return view('projects', compact('page', 'projects', 'categories'));
    }

    /**
     * Display a specific project.
     */
    public function project(Project $project)
    {
        $relatedProjects = Project::active()
            ->where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->take(3)
            ->get();
            
        return view('project-detail', compact('project', 'relatedProjects'));
    }

    /**
     * Display the blog page.
     */
    public function blog()
    {
        $page = Page::getByName('blog');
        $blogs = Blog::published()->orderBy('published_at', 'desc')->paginate(6);
        $categories = Blog::published()->distinct()->pluck('category')->filter();
        $featuredBlogs = Blog::published()->featured()->orderBy('published_at', 'desc')->take(3)->get();
        
        return view('blog', compact('page', 'blogs', 'categories', 'featuredBlogs'));
    }

    /**
     * Display a specific blog post.
     */
    public function blogPost(Blog $blog)
    {
        // Increment views
        $blog->incrementViews();
        
        $relatedBlogs = Blog::published()
            ->where('id', '!=', $blog->id)
            ->where('category', $blog->category)
            ->take(3)
            ->get();
            
        return view('blog-detail', compact('blog', 'relatedBlogs'));
    }

    /**
     * Display the contact page.
     */
    public function contact()
    {
        $page = Page::getByName('contact');
        $services = Service::active()->ordered()->get();
        
        return view('contact', compact('page', 'services'));
    }

    /**
     * Handle contact form submission.
     */
    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            'company' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
        ]);

        Contact::create($validated);

        return redirect()->back()->with('success', 'Thank you for your message! We will get back to you soon.');
    }

    /**
     * Handle TC request form submission.
     */
    public function tcRequestSubmit(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
            'description' => 'required|string|max:2000',
            'service_id' => 'nullable|exists:services,id',
            'attached_file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
        ]);

        if ($request->hasFile('attached_file')) {
            $validated['attached_file'] = $request->file('attached_file')->store('tc-requests');
        }

        TcRequest::create($validated);

        return redirect()->back()->with('success', 'Your service request has been submitted successfully! We will review it and get back to you soon.');
    }
}
