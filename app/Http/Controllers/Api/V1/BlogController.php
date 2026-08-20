<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Models\Blog;
use App\Repositories\Interfaces\BlogRepositoryInterface;
use App\Services\CMSManager;
use App\Services\JsonLdService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
class BlogController extends Controller
{
    protected CMSManager $cmsManager;
    protected BlogRepositoryInterface $blogRepository;
    protected JsonLdService $jsonLd;

    public function __construct(CMSManager $cmsManager, BlogRepositoryInterface $blogRepository, JsonLdService $jsonLd)
    {
        $this->cmsManager = $cmsManager;
        $this->blogRepository = $blogRepository;
        $this->jsonLd = $jsonLd;
    }

    /**
     * Get paginated blog posts.
     */
    public function index(): JsonResponse
    {
        $pageNumber = request()->get('page', 1);
        $perPage = request()->get('per_page', 6);
        $search = request()->get('search', '');
        $category = request()->get('category');
        $sort = request()->get('sort', 'published_at'); // published_at, title
        $direction = request()->get('direction', 'desc');
        $isActive = request()->get('is_active', true);

        // Make cache key dynamic based on all parameters
        $cacheKey = "api_blogs_index_p{$pageNumber}_pp{$perPage}_s{$search}_c{$category}_sort{$sort}_{$direction}_act{$isActive}";

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($perPage, $search, $category, $sort, $direction, $isActive) {
            // Note: Since BlogRepository's getFilteredActive didn't previously include category, we will fetch without it or rely on search for now, as it's a future column.
            $blogs = $this->blogRepository->getFilteredActive(
                $perPage,
                $search,
                $sort,
                $direction,
                $isActive
            );
            
            // Recent blogs still strictly active and newest
            // Can use base repository's pagination or custom query for top 3
            $recentBlogs = $this->blogRepository->getPublished(3) ?? $this->blogRepository->getActive(3);

            $page = $this->cmsManager->resolvePage('blog', [
                'title' => __('cms.blog.title'),
                'breadcrumb_title' => __('cms.blog.breadcrumb_title'),
                'image' => __('cms.blog.image')
            ], true);

            return response()->json([
                'blogs' => BlogResource::collection($blogs),
                'pagination' => [
                    'current_page' => $blogs->currentPage(),
                    'last_page' => $blogs->lastPage(),
                    'per_page' => $blogs->perPage(),
                    'total' => $blogs->total(),
                ],
                'recent_blogs' => BlogResource::collection($recentBlogs),
                'page' => [
                    'title' => $page->model?->title ?: ($page->title ?? __('cms.blog.title')),
                    'breadcrumb_title' => $page->model?->title ?: ($page->breadcrumb_title ?? __('cms.blog.breadcrumb_title')),
                    'image' => $page->image ?? null,
                    'meta_title' => $page->model->meta_title ?? null,
                    'meta_description' => $page->model->meta_description ?? null,
                ],
                'jsonLd' => [
                    $this->jsonLd->blogList($blogs),
                    $this->jsonLd->breadcrumb([
                        'Home' => config('app.frontend_url', config('app.url')),
                        'Blog' => config('app.frontend_url', config('app.url')) . '/blog',
                    ]),
                ],
            ]);
        });
    }

    /**
     * Get a single blog post by slug.
     */
    public function show(string $slug): JsonResponse
    {
        try {
            $data = Cache::remember("api_blog_{$slug}", now()->addMinutes(15), function () use ($slug) {
                $blog = $this->blogRepository->findBySlug($slug);
                $recentBlogs = $this->blogRepository->getRecent($blog, 3);

                $frontendUrl = config('app.frontend_url', config('app.url'));

                return [
                    'blog' => new BlogResource($blog),
                    'recent_blogs' => BlogResource::collection($recentBlogs),
                    'jsonLd' => [
                        $this->jsonLd->blogArticle($blog),
                        $this->jsonLd->breadcrumb([
                            'Home' => $frontendUrl,
                            'Blog' => $frontendUrl . '/blog',
                            $blog->title => $frontendUrl . '/blog/' . $blog->slug,
                        ]),
                    ],
                ];
            });

            return response()->json($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Blog post not found'], 404);
        }
    }
}
