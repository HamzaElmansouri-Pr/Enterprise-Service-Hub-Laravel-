<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Resources\ProjectResource;
use App\Http\Resources\BlogResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\SliderResource;
use App\Http\Resources\PartnerResource;
use App\Http\Resources\SectionResource;
use App\Services\HomePageService;
use App\Services\CMSManager;
use App\Services\JsonLdService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
class HomeController extends Controller
{
    protected CMSManager $cmsManager;
    protected JsonLdService $jsonLd;
    protected HomePageService $homePageService;

    public function __construct(CMSManager $cmsManager, JsonLdService $jsonLd, HomePageService $homePageService)
    {
        $this->cmsManager = $cmsManager;
        $this->jsonLd = $jsonLd;
        $this->homePageService = $homePageService;
    }

    /**
     * Get all homepage data in a single request.
     */
    public function __invoke(): JsonResponse
    {
        $data = Cache::remember('api_home_data', now()->addMinutes(30), function () {
            // CMS data
            $cms = $this->cmsManager->resolvePage('home', [
                'heroTitle' => __('cms.home.hero_title'),
                'heroSubtitle' => __('cms.home.hero_subtitle'),
                'heroButtonText' => __('cms.home.hero_button_text'),
                'heroImage' => __('cms.home.hero_image'),
                'services_title' => __('cms.home.services_title'),
                'services_subtitle' => __('cms.home.services_subtitle'),
                'projects_title' => __('cms.home.projects_title'),
                'projects_subtitle' => __('cms.home.projects_subtitle'),
                'reviews_title' => __('cms.home.reviews_title'),
                'reviews_subtitle' => __('cms.home.reviews_subtitle'),
                'blog_title' => __('cms.home.blog_title'),
                'blog_subtitle' => __('cms.home.blog_subtitle'),
                'cta' => [
                    'title' => __('cms.home.cta_title'),
                    'subtitle' => __('cms.home.cta_subtitle'),
                    'description' => __('cms.home.cta_description'),
                    'button_text' => __('cms.home.cta_button_text'),
                ],
                'about' => [
                    'title' => __('cms.home.about_title'),
                    'subtitle' => __('cms.home.about_subtitle'),
                    'description' => __('cms.home.about_description'),
                    'image' => __('cms.home.about_image'),
                    'meta_data' => ['features' => []],
                ],
            ], true);
            $homeData = $this->homePageService->getHomeData($cms);

            return [
                'cms' => [
                    'heroTitle' => $cms->heroTitle ?? null,
                    'heroSubtitle' => $cms->heroSubtitle ?? null,
                    'heroButtonText' => $cms->heroButtonText ?? null,
                    'heroImage' => $cms->heroImage ?? null,
                    'services_title' => $cms->services_title ?? null,
                    'services_subtitle' => $cms->services_subtitle ?? null,
                    'projects_title' => $cms->projects_title ?? null,
                    'projects_subtitle' => $cms->projects_subtitle ?? null,
                    'reviews_title' => $cms->reviews_title ?? null,
                    'reviews_subtitle' => $cms->reviews_subtitle ?? null,
                    'blog_title' => $cms->blog_title ?? null,
                    'blog_subtitle' => $cms->blog_subtitle ?? null,
                    'cta' => $cms->cta ?? null,
                    'about' => $cms->about ?? null,
                ],
                'sliders' => SliderResource::collection($homeData['sliders'])->resolve(),
                'services' => ServiceResource::collection($homeData['services'])->resolve(),
                'projects' => ProjectResource::collection($homeData['projects'])->resolve(),
                'reviews' => ReviewResource::collection($homeData['reviews'])->resolve(),
                'blogs' => BlogResource::collection($homeData['blogs'])->resolve(),
                'partners' => PartnerResource::collection($homeData['partners'])->resolve(),
                'sections' => SectionResource::collection($homeData['sections'])->resolve(),
                'jsonLd' => [
                    $this->jsonLd->organization((array) $cms),
                    $this->jsonLd->webSite(),
                ],
            ];
        });

        return response()->json($data);
    }
}
