<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Repositories\Interfaces\ProjectRepositoryInterface;
use App\Services\CMSManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProjectController extends Controller
{
    protected CMSManager $cmsManager;
    protected ProjectRepositoryInterface $projectRepository;

    public function __construct(CMSManager $cmsManager, ProjectRepositoryInterface $projectRepository)
    {
        $this->cmsManager = $cmsManager;
        $this->projectRepository = $projectRepository;
    }

    /**
     * Get all active projects with optional filtering.
     */
    public function index(Request $request): JsonResponse
    {
        $category = $request->get('category', '');
        $search = $request->get('search', '');
        $sort = $request->get('sort', 'order_index');
        $direction = $request->get('direction', 'asc');
        $isActive = $request->get('is_active', true);
        $pageNumber = $request->get('page', 1);
        $perPage = $request->get('per_page', 12);
        
        $cacheKey = "api_projects_index_" . md5($category . $search . $sort . $direction . $isActive . $pageNumber . $perPage);

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($request, $category, $search, $sort, $direction, $isActive, $perPage) {
            $projects = $this->projectRepository->getFilteredActive(
                $perPage,
                $category,
                $search,
                $sort,
                $direction,
                $isActive
            );

            $categories = $this->projectRepository->getActiveCategories();

            $page = $this->cmsManager->resolvePage('projects', [
                'title' => __('cms.projects.title'),
                'breadcrumb_title' => __('cms.projects.breadcrumb_title'),
                'image' => __('cms.projects.image'),
            ], true);

            return response()->json([
                'projects' => ProjectResource::collection($projects),
                'pagination' => [
                    'current_page' => $projects->currentPage(),
                    'last_page' => $projects->lastPage(),
                    'per_page' => $projects->perPage(),
                    'total' => $projects->total(),
                ],
                'categories' => $categories,
                'page' => [
                    'title' => $page->title ?? __('cms.projects.title'),
                    'breadcrumb_title' => $page->breadcrumb_title ?? __('cms.projects.breadcrumb_title'),
                    'image' => $page->image ?? null,
                    'meta_title' => $page->model->meta_title ?? null,
                    'meta_description' => $page->model->meta_description ?? null,
                ],
            ]);
        });
    }

    /**
     * Get a single project by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $project = $this->projectRepository->findBySlug($slug);
        $relatedProjects = $this->projectRepository->getRelatedProjects($project, 3);

        return response()->json([
            'project' => new ProjectResource($project),
            'related_projects' => ProjectResource::collection($relatedProjects),
        ]);
    }
}
