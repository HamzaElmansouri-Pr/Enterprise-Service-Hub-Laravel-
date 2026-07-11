<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    public function index()
    {
        $frontendUrl = rtrim(config('app.frontend_url', 'http://localhost:3000'), '/');
        
        $blogs = Blog::where('is_active', true)->whereNotNull('published_at')->get();
        $projects = Project::where('is_active', true)->get();
        $services = Service::where('is_active', true)->get();
        
        $content = view('sitemap.index', [
            'frontendUrl' => $frontendUrl,
            'blogs' => $blogs,
            'projects' => $projects,
            'services' => $services,
        ])->render();
        
        return Response::make($content, 200, [
            'Content-Type' => 'text/xml'
        ]);
    }
}
