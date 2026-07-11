<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\CMSManager;
use Illuminate\Http\JsonResponse;

class AboutController extends Controller
{
    protected CMSManager $cmsManager;

    public function __construct(CMSManager $cmsManager)
    {
        $this->cmsManager = $cmsManager;
    }

    /**
     * Get the about page CMS content.
     */
    public function __invoke(): JsonResponse
    {
        $page = $this->cmsManager->resolvePage('about', [
            'breadcrumb_title' => __('cms.about.breadcrumb_title'),
            'image' => __('cms.about.image'),
            'about' => null,
            'stats' => null,
            'values' => null,
            'history' => null,
            'team' => null,
        ], true);

        return response()->json([
            'page' => [
                'title' => $page->title ?? __('cms.about.title'),
                'breadcrumb_title' => $page->breadcrumb_title ?? __('cms.about.breadcrumb_title'),
                'image' => $page->image ?? null,
                'about' => $page->about ?? null,
                'stats' => $page->stats ?? null,
                'values' => $page->values ?? null,
                'history' => $page->history ?? null,
                'team' => $page->team ?? null,
                'meta_title' => $page->model->meta_title ?? null,
                'meta_description' => $page->model->meta_description ?? null,
            ],
        ]);
    }
}
