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
        $category = request()->get('category', '');
        $sort = request()->get('sort', 'published_at'); // published_at, title
        $direction = request()->get('direction', 'desc');
        // Drafts are only available through the authenticated back office.
        $isActive = true;

        // Make cache key dynamic based on all parameters
        $locale = app()->getLocale();
        $cacheKey = "api_blogs_index_{$locale}_p{$pageNumber}_pp{$perPage}_s{$search}_c{$category}_sort{$sort}_{$direction}";

        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($perPage, $search, $category, $sort, $direction, $isActive) {
            $blogs = $this->blogRepository->getFilteredActive(
                $perPage,
                $category,
                $search,
                $sort,
                $direction,
                $isActive
            );
            
            $categories = $this->blogRepository->getActiveCategories();

            // Recent blogs still strictly active and newest
            $recentBlogs = $this->blogRepository->getActive(3);

            $page = $this->cmsManager->resolvePage('blog', [
                'title' => __('cms.blog.title'),
                'breadcrumb_title' => __('cms.blog.breadcrumb_title'),
                'image' => __('cms.blog.image')
            ], true);

            $headerFields = [
                'eyebrow',
                'title',
                'breadcrumb_title',
                'description',
                'button_text',
                'button_url',
                'grid_eyebrow',
                'grid_title',
                'grid_description',
                'image',
            ];
            $blogHeader = $page->model?->sections->firstWhere('type', 'blog-page-header');
            $configuredFields = $blogHeader
                ? $blogHeader->contentBlocks->pluck('key')->intersect($headerFields)->values()->all()
                : [];

            return response()->json([
                'blogs' => BlogResource::collection($blogs),
                'categories' => $categories,
                'pagination' => [
                    'current_page' => $blogs->currentPage(),
                    'last_page' => $blogs->lastPage(),
                    'per_page' => $blogs->perPage(),
                    'total' => $blogs->total(),
                ],
                'recent_blogs' => BlogResource::collection($recentBlogs),
                'page' => [
                    'title' => $page->title ?? __('cms.blog.title'),
                    'breadcrumb_title' => $page->breadcrumb_title ?? __('cms.blog.breadcrumb_title'),
                    'image' => $page->image ?? null,
                    'meta_title' => $page->model?->meta_title ?? null,
                    'meta_description' => $page->model?->meta_description ?? null,
                    'eyebrow' => $page->eyebrow ?? null,
                    'description' => $page->description ?? null,
                    'button_text' => $page->button_text ?? null,
                    'button_url' => $page->button_url ?? null,
                    'grid_eyebrow' => $page->grid_eyebrow ?? null,
                    'grid_title' => $page->grid_title ?? null,
                    'grid_description' => $page->grid_description ?? null,
                    'configured_fields' => $configuredFields,
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
        $locale = app()->getLocale();
        try {
            $data = Cache::remember("api_blog_{$locale}_{$slug}", now()->addMinutes(15), function () use ($slug) {
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
