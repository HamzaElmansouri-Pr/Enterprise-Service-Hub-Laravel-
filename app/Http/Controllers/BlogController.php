<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Services\CMSManager;
use Illuminate\View\View;

class BlogController extends Controller
{
    protected CMSManager $cmsManager;

    public function __construct(CMSManager $cmsManager)
    {
        $this->cmsManager = $cmsManager;
    }

    /**
     * Display a paginated listing of blog posts.
     */
    public function index(): View
    {
        $blogs = Blog::active()->with('author')->orderBy('published_at', 'desc')->paginate(6);
        $recentBlogs = Blog::active()->orderBy('published_at', 'desc')->take(3)->get();

        $page = $this->cmsManager->resolvePage('blog', [
            'title' => 'Our Blog',
            'breadcrumb_title' => 'Latest <span>News</span>',
            'image' => 'assets/img/breadcrumb-bg.jpg'
        ]);

        if ($page->model) {
            $page->title = $page->model->title ?: $page->title;
            $page->breadcrumb_title = $page->model->title ?: $page->breadcrumb_title;
        }

        return view('blog', compact('blogs', 'recentBlogs', 'page'));
    }

    /**
     * Display a specific blog post.
     */
    public function show(string $slug): View
    {
        $blog = Blog::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $recentBlogs = Blog::active()->where('id', '!=', $blog->id)->orderBy('published_at', 'desc')->take(3)->get();
        
        return view('blog-detail', compact('blog', 'recentBlogs'));
    }
}
