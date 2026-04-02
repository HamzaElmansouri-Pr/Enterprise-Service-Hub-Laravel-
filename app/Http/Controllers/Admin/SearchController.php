<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Project;
use App\Models\Service;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Global Admin Search: Query Services, Projects, and Blogs.
     */
    public function query(Request $request)
    {
        $q = $request->query('q');
        
        if (empty($q) || strlen($q) < 2) {
            return response()->json([]);
        }

        $results = [];

        // Search Services
        $services = Service::where('title', 'LIKE', "%{$q}%")
            ->take(5)
            ->get(['id', 'title']);
        foreach ($services as $service) {
            $results[] = [
                'type' => 'Service',
                'title' => $service->title,
                'url' => route('admin.services.edit', $service->id),
                'icon' => 'fas fa-cogs'
            ];
        }

        // Search Projects
        $projects = Project::where('title', 'LIKE', "%{$q}%")
            ->take(5)
            ->get(['id', 'title']);
        foreach ($projects as $project) {
            $results[] = [
                'type' => 'Project',
                'title' => $project->title,
                'url' => route('admin.projects.edit', $project->id),
                'icon' => 'fas fa-project-diagram'
            ];
        }

        // Search Blogs
        $blogs = Blog::where('title', 'LIKE', "%{$q}%")
            ->take(5)
            ->get(['id', 'title']);
        foreach ($blogs as $blog) {
            $results[] = [
                'type' => 'Blog',
                'title' => $blog->title,
                'url' => route('admin.blogs.edit', $blog->id),
                'icon' => 'fas fa-blog'
            ];
        }

        return response()->json($results);
    }
}
