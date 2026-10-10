<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Models\Service;
use App\Repositories\Interfaces\ServiceRepositoryInterface;
use App\Services\CMSManager;
use App\Services\JsonLdService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
class ServiceController extends Controller
{
    protected CMSManager $cmsManager;
    protected ServiceRepositoryInterface $serviceRepository;
    protected JsonLdService $jsonLd;

    public function __construct(CMSManager $cmsManager, ServiceRepositoryInterface $serviceRepository, JsonLdService $jsonLd)
    {
        $this->cmsManager = $cmsManager;
        $this->serviceRepository = $serviceRepository;
        $this->jsonLd = $jsonLd;
    }

    /**
     * Get all active services.
     */
    public function index(): JsonResponse
    {
        $pageNumber = request()->get('page', 1);
        $perPage = request()->get('per_page', 12);
        
        // Extract filters
        $search = request()->get('search');
        $sort = request()->get('sort', 'order_index'); // order_index, created_at
        $direction = request()->get('direction', 'asc');
        // This is a public endpoint. Inactive records are back-office drafts and
        // must never be selectable with a query parameter.
        $isActive = true;

        // Build dynamic cache key
        $locale = app()->getLocale();
        $cacheKey = "api_services_index_{$locale}_p{$pageNumber}_pp{$perPage}_s{$search}_sort{$sort}_{$direction}";

        return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($perPage, $search, $sort, $direction, $isActive) {
            $services = $this->serviceRepository->getFilteredActive(
                $perPage,
                $search,
                $sort,
                $direction,
                $isActive
            );

            $page = $this->cmsManager->resolvePage('services', [
                'title' => __('cms.services.title'),
                'breadcrumb_title' => __('cms.services.breadcrumb_title'),
                'image' => __('cms.services.image'),
            ], true);

            return response()->json([
                'services' => ServiceResource::collection($services),
                'pagination' => [
                    'current_page' => $services->currentPage(),
                    'last_page' => $services->lastPage(),
                    'per_page' => $services->perPage(),
                    'total' => $services->total(),
                ],
                'page' => [
                    'title' => $page->title ?? __('cms.services.title'),
                    'breadcrumb_title' => $page->breadcrumb_title ?? __('cms.services.breadcrumb_title'),
                    'image' => $page->image ?? null,
                    'meta_title' => $page->model->meta_title ?? null,
                    'meta_description' => $page->model->meta_description ?? null,
                    'eyebrow' => $page->eyebrow ?? null,
                    'description' => $page->description ?? null,
                    'button_text' => $page->button_text ?? null,
                    'button_url' => $page->button_url ?? null,
                    'grid_eyebrow' => $page->grid_eyebrow ?? null,
                    'grid_title' => $page->grid_title ?? null,
                    'grid_description' => $page->grid_description ?? null,
                ],
                'jsonLd' => [
                    $this->jsonLd->serviceList($services),
                    $this->jsonLd->breadcrumb([
                        'Home' => config('app.frontend_url', config('app.url')),
                        'Services' => config('app.frontend_url', config('app.url')) . '/services',
                    ]),
                ],
            ]);
        });
    }

    /**
     * Get a single service by slug.
     */
    public function show(string $slug): JsonResponse
    {
        $locale = app()->getLocale();
        try {
            $data = Cache::remember("api_service_{$locale}_{$slug}", now()->addMinutes(15), function () use ($slug) {
                $service = $this->serviceRepository->findBySlug($slug);
                $allServices = $this->serviceRepository->getActive(20);

                $frontendUrl = config('app.frontend_url', config('app.url'));

                return [
                    'service' => new ServiceResource($service),
                    'all_services' => ServiceResource::collection($allServices),
                    'jsonLd' => [
                        $this->jsonLd->service($service),
                        $this->jsonLd->breadcrumb([
                            'Home' => $frontendUrl,
                            'Services' => $frontendUrl . '/services',
                            $service->title => $frontendUrl . '/services/' . $service->slug,
                        ]),
                    ],
                ];
            });

            return response()->json($data);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['message' => 'Service not found'], 404);
        }
    }
}
