<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::ordered()->paginate(10);
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'client' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'project_date' => 'nullable|date',
            'project_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'result' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $projectDir = public_path('assets/img/project');
            if (!file_exists($projectDir)) {
                mkdir($projectDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($projectDir, $imageName);
            $validated['image'] = 'assets/img/project/' . $imageName;
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            $galleryImages = [];
            $galleryDir = public_path('assets/img/project/gallery');
            if (!file_exists($galleryDir)) {
                mkdir($galleryDir, 0755, true);
            }

            foreach ($request->file('gallery') as $index => $galleryImage) {
                $galleryImageName = time() . '_' . Str::slug($validated['title']) . '_gallery_' . $index . '.' . $galleryImage->getClientOriginalExtension();
                $galleryImage->move($galleryDir, $galleryImageName);
                $galleryImages[] = 'assets/img/project/gallery/' . $galleryImageName;
            }
            $validated['gallery'] = $galleryImages;
        }

        // Convert technologies array to JSON
        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_filter($validated['technologies']); // Remove empty values
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully!');
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
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'client' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'project_date' => 'nullable|date',
            'project_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|array',
            'technologies.*' => 'string|max:100',
            'challenge' => 'nullable|string',
            'solution' => 'nullable|string',
            'result' => 'nullable|string',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer|min:0',
        ]);

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($project->image && file_exists(public_path($project->image))) {
                unlink(public_path($project->image));
            }
            
            $image = $request->file('image');
            $imageName = time() . '_' . Str::slug($validated['title']) . '.' . $image->getClientOriginalExtension();
            
            // Create the directory if it doesn't exist
            $projectDir = public_path('assets/img/project');
            if (!file_exists($projectDir)) {
                mkdir($projectDir, 0755, true);
            }
            
            // Move the image to the assets directory
            $image->move($projectDir, $imageName);
            $validated['image'] = 'assets/img/project/' . $imageName;
        }

        // Handle gallery images upload
        if ($request->hasFile('gallery')) {
            // Delete old gallery images if exist
            if ($project->gallery) {
                foreach ($project->gallery as $oldImage) {
                    if (file_exists(public_path($oldImage))) {
                        unlink(public_path($oldImage));
                    }
                }
            }

            $galleryImages = [];
            $galleryDir = public_path('assets/img/project/gallery');
            if (!file_exists($galleryDir)) {
                mkdir($galleryDir, 0755, true);
            }

            foreach ($request->file('gallery') as $index => $galleryImage) {
                $galleryImageName = time() . '_' . Str::slug($validated['title']) . '_gallery_' . $index . '.' . $galleryImage->getClientOriginalExtension();
                $galleryImage->move($galleryDir, $galleryImageName);
                $galleryImages[] = 'assets/img/project/gallery/' . $galleryImageName;
            }
            $validated['gallery'] = $galleryImages;
        }

        // Convert technologies array to JSON
        if (isset($validated['technologies'])) {
            $validated['technologies'] = array_filter($validated['technologies']); // Remove empty values
        }

        $project->update($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        // Delete main image if exists
        if ($project->image && file_exists(public_path($project->image))) {
            unlink(public_path($project->image));
        }

        // Delete gallery images if exist
        if ($project->gallery) {
            foreach ($project->gallery as $galleryImage) {
                if (file_exists(public_path($galleryImage))) {
                    unlink(public_path($galleryImage));
                }
            }
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully!');
    }

    /**
     * Toggle project status
     */
    public function toggleStatus(Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);
        
        $status = $project->is_active ? 'activated' : 'deactivated';
        return redirect()->back()
            ->with('success', "Project {$status} successfully!");
    }

    /**
     * Toggle featured status
     */
    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);
        
        $status = $project->is_featured ? 'featured' : 'unfeatured';
        return redirect()->back()
            ->with('success', "Project {$status} successfully!");
    }
}
