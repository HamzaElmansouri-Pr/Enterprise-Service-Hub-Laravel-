<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderBy('order_index')->paginate(10);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $data['image'] = 'storage/' . $path;
        }

        $data['title'] = purify_html($data['title']);
        $data['description'] = purify_html($data['description'] ?? '');

        Project::create($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $data = $request->validated();
        
        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = Str::slug($data['title']) . '-' . time();
            
            // Professional Optimization: Using Intervention Image if available
            if (class_exists('\Intervention\Image\Laravel\Facades\Image')) {
                $manager = \Intervention\Image\Laravel\Facades\Image::getFacadeRoot();
                
                // 1. Optimized Main Image (WebP, Max 1200px)
                $mainPath = 'projects/' . $filename . '.webp';
                $image = $manager->read($file);
                $image->scale(width: 1200);
                Storage::disk('public')->put($mainPath, (string) $image->toWebp(80));
                $data['image'] = 'storage/' . $mainPath;
                
                // 2. Thumbnail (WebP, 400x300 Cover)
                $thumbPath = 'projects/thumbs/' . $filename . '.webp';
                $thumb = $manager->read($file);
                $thumb->cover(400, 300);
                Storage::disk('public')->put($thumbPath, (string) $thumb->toWebp(70));
                // We could store this in a separate column if we had one
            } else {
                // Fallback to standard upload
                $path = $file->store('projects', 'public');
                $data['image'] = 'storage/' . $path;
            }
        }

        // Handle OG Image
        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('seo/og', 'public');
            $data['og_image'] = 'storage/' . $path;
        }

        $data['title'] = purify_html($data['title']);
        $data['description'] = purify_html($data['description'] ?? '');

        $project->update($data);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
