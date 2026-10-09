<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;

class GlobalController extends Controller
{
    public function index(): JsonResponse
    {
        $cacheKey = 'api_global_data_' . app()->getLocale();

        $globalData = Cache::remember($cacheKey, now()->addMinutes(60), function () {
            $siteInfo = Section::where('type', 'site-info')->with('contentBlocks')->first();
            $footerContent = Section::where('type', 'footer-content')->with('contentBlocks')->first();

            $siteInfoData = $siteInfo ? $siteInfo->contentBlocks->pluck('content', 'key')->toArray() : [];
            $footerContentData = $footerContent ? $footerContent->contentBlocks->pluck('content', 'key')->toArray() : [];

            // Resolve any images within the global settings
            // The CMS stores these under site_* keys. Keep those keys for
            // compatibility while exposing the public API names consumed by
            // the frontend.
            if (isset($siteInfoData['site_logo']) && is_string($siteInfoData['site_logo'])) {
                $siteInfoData['logo'] = resolve_image_url($siteInfoData['site_logo']);
            } elseif (isset($siteInfoData['logo']) && is_string($siteInfoData['logo'])) {
                $siteInfoData['logo'] = resolve_image_url($siteInfoData['logo']);
            }
            if (isset($siteInfoData['site_favicon']) && is_string($siteInfoData['site_favicon'])) {
                $siteInfoData['favicon'] = resolve_image_url($siteInfoData['site_favicon']);
            } elseif (isset($siteInfoData['favicon']) && is_string($siteInfoData['favicon'])) {
                $siteInfoData['favicon'] = resolve_image_url($siteInfoData['favicon']);
            }
            if (isset($siteInfoData['site_keywords'])) {
                $siteInfoData['seo_keywords'] = $siteInfoData['site_keywords'];
            }
            if (isset($footerContentData['footer_logo']) && is_string($footerContentData['footer_logo'])) {
                $footerContentData['footer_logo'] = resolve_image_url($footerContentData['footer_logo']);
            }

            return [
                'site_info' => $siteInfoData,
                'footer_content' => $footerContentData,
            ];
        });

        return response()->json($globalData);
    }
}
