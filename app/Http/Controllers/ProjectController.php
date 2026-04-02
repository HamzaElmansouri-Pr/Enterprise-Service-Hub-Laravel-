<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Project;
use App\Services\CMSManager;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected CMSManager $cmsManager;

    public function __construct(CMSManager $cmsManager)
    {
        $this->cmsManager = $cmsManager;
    }

    /**
     * Display a listing of projects.
     */
    public function index(Request $request): View
    {
        $query = Project::where('is_active', true);

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $projects = $query->orderBy('order_index')->get();

        $categories = Project::where('is_active', true)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        $page = $this->cmsManager->resolvePage('projects', [
            'title' => 'Our Projects',
            'breadcrumb_title' => 'Our <span>Projects</span>',
            'image' => 'assets/img/breadcrumb-bg.jpg'
        ]);

        return view('projects', compact('projects', 'page', 'categories'));
    }

    /**
     * Display a specific project.
     */
    public function show(string $slug): View
    {
        $project = Project::where('slug', $slug)->where('is_active', true)->firstOrFail();
        $relatedProjects = Project::where('is_active', true)->where('id', '!=', $project->id)->inRandomOrder()->take(3)->get();
        
        return view('project-detail', compact('project', 'relatedProjects'));
    }
}
