<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Category;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{
    use AuthorizesRequests;

    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(ProjectRepositoryInterface $projectRepository)
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = $this->projectRepository->paginate(10, ['categories'], ['order_index' => 'asc']);
        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('order_index')->get();
        return view('admin.projects.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request, \App\Actions\Projects\SaveProjectAction $saveProjectAction)
    {
        $project = $saveProjectAction->execute($request->validated());

        if (empty($request->validated()['meta_description'] ?? null)) {
            \App\Jobs\GenerateSeoMetaJob::dispatch($project);
        }

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
        $project->load('categories');
        $categories = Category::orderBy('order_index')->get();
        return view('admin.projects.edit', compact('project', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project, \App\Actions\Projects\SaveProjectAction $saveProjectAction)
    {
        $saveProjectAction->execute($request->validated(), $project);

        if (empty($request->validated()['meta_description'] ?? null)) {
            \App\Jobs\GenerateSeoMetaJob::dispatch($project->refresh());
        }

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $this->projectRepository->delete($project->id);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }

    public function toggleStatus(Project $project)
    {
        $project->update(['is_active' => !$project->is_active]);

        return back()->with('success', 'Project status updated successfully.');
    }

    public function toggleFeatured(Project $project)
    {
        $project->update(['is_featured' => !$project->is_featured]);

        return back()->with('success', 'Project featured status updated successfully.');
    }
}
