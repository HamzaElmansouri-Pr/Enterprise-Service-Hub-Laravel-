<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\AI\AIService;
use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Service;
use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    protected AIService $ai;

    public function __construct(AIService $ai)
    {
        $this->ai = $ai;
    }

    /**
     * Perform a full-text keyword search across multiple models.
     */
    public function index(Request $request)
    {
        $query = $request->input('q');

        if (empty($query)) {
            return response()->json([
                'success' => true,
                'data' => []
            ]);
        }

        try {
            // Search all models
            $blogs = Blog::search($query)->take(10)->get();
            $services = Service::search($query)->take(10)->get();
            $projects = Project::search($query)->take(10)->get();

            $results = $this->transformResults(
                $blogs->filter(fn (Blog $blog) => $blog->is_active && $blog->published_at),
                $services->filter(fn (Service $service) => $service->is_active),
                $projects->filter(fn (Project $project) => $project->is_active),
            );

            return response()->json([
                'success' => true,
                'data' => $results
            ]);
        } catch (\Exception $e) {
            Log::error('Search failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Search service is currently unavailable.',
                'data' => []
            ], 503);
        }
    }

    /**
     * Perform a semantic (vector) search across multiple models.
     *
     * POST /api/v1/search/semantic { query, locale?, limit? }
     */
    public function semantic(Request $request)
    {
        $request->validate([
            'query' => 'required|string|max:500',
            'locale' => 'nullable|string|max:5',
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $query = $request->input('query');
        $locale = $request->input('locale', app()->getLocale());
        $limit = $request->input('limit', 10);

        try {
            // 1. Generate the query embedding (cache for 1 hour to avoid duplicate API calls)
            $cacheKey = 'semantic_embed_' . md5($query);
            $queryVector = Cache::remember($cacheKey, 3600, function () use ($query) {
                return $this->ai->embed($query);
            });

            if (empty($queryVector)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to generate query embedding.',
                    'data' => []
                ], 422);
            }

            // 2. Perform hybrid search on each model via Meilisearch
            $perModel = (int) ceil($limit / 3);

            $blogs = Blog::search($query, function ($meilisearch, $query, $options) use ($queryVector, $perModel) {
                $options['vector'] = $queryVector;
                $options['hybrid'] = [
                    'semanticRatio' => 0.7,
                    'embedder' => 'default',
                ];
                $options['limit'] = $perModel;
                return $meilisearch->search($query, $options);
            })->get();

            $services = Service::search($query, function ($meilisearch, $query, $options) use ($queryVector, $perModel) {
                $options['vector'] = $queryVector;
                $options['hybrid'] = [
                    'semanticRatio' => 0.7,
                    'embedder' => 'default',
                ];
                $options['limit'] = $perModel;
                return $meilisearch->search($query, $options);
            })->get();

            $projects = Project::search($query, function ($meilisearch, $query, $options) use ($queryVector, $perModel) {
                $options['vector'] = $queryVector;
                $options['hybrid'] = [
                    'semanticRatio' => 0.7,
                    'embedder' => 'default',
                ];
                $options['limit'] = $perModel;
                return $meilisearch->search($query, $options);
            })->get();

            // 3. Transform & merge results
            $results = $this->transformResults($blogs, $services, $projects, $locale);

            return response()->json([
                'success' => true,
                'data' => $results->take($limit)->values()
            ]);
        } catch (\Exception $e) {
            Log::error('Semantic search failed: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Semantic search service is currently unavailable.',
                'data' => []
            ], 503);
        }
    }

    /**
     * Transform model collections into a unified result set.
     */
    protected function transformResults($blogs, $services, $projects, ?string $locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        $results = collect();

        foreach ($blogs as $blog) {
            $results->push([
                'id' => $blog->id,
                'type' => 'blog',
                'title' => $blog->getTranslation('title', $locale, false) ?? $blog->title,
                'url_slug' => $blog->slug,
                'url' => '/blog/' . $blog->slug,
                'excerpt' => $blog->getTranslation('excerpt', $locale, false) ?? $blog->excerpt,
                'image' => $blog->image ? resolve_image_url($blog->image) : null,
                'published_at' => $blog->published_at,
            ]);
        }

        foreach ($services as $service) {
            $results->push([
                'id' => $service->id,
                'type' => 'service',
                'title' => $service->getTranslation('title', $locale, false) ?? $service->title,
                'url_slug' => $service->slug,
                'url' => '/services/' . $service->slug,
                'excerpt' => $service->getTranslation('subtitle', $locale, false) ?? $service->subtitle,
                'image' => $service->image ? resolve_image_url($service->image) : null,
                'icon' => $service->icon,
            ]);
        }

        foreach ($projects as $project) {
            $results->push([
                'id' => $project->id,
                'type' => 'project',
                'title' => $project->getTranslation('title', $locale, false) ?? $project->title,
                'url_slug' => $project->slug,
                'url' => '/projects/' . $project->slug,
                'excerpt' => strip_tags($project->getTranslation('description', $locale, false) ?? $project->description),
                'image' => $project->image ? resolve_image_url($project->image) : null,
                'category' => $project->category,
            ]);
        }

        return $results;
    }
}
