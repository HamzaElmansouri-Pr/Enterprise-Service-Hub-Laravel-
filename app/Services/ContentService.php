<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Interfaces\ContentRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cache;

class ContentService
{
    protected ContentRepositoryInterface $contentRepository;

    public function __construct(ContentRepositoryInterface $contentRepository)
    {
        $this->contentRepository = $contentRepository;
    }

    public function getContent(string $contentType): array
    {
        return Cache::remember("content.{$contentType}", 3600, function () use ($contentType) {
            return $this->contentRepository->get($contentType);
        });
    }
    
    public function getPageByName(string $name)
    {
        return Cache::remember("page.{$name}", 3600, function () use ($name) {
            return $this->contentRepository->getPageByName($name);
        });
    }

    public function updateContent(string $contentType, array $data, Request $request): void
    {
        // Handling file uploads in service
        $imageFields = $this->getImageFields($contentType);
        
        foreach ($imageFields as $fieldName => $fileInputName) {
            // Remove the file input field from data to prevent serialization issues
            // This is critical because UploadedFile objects cannot be serialized in session/cache
            if (array_key_exists($fileInputName, $data)) {
                unset($data[$fileInputName]);
            }

            if ($request->hasFile($fileInputName)) {
                $file = $request->file($fileInputName);
                $path = $file->store('uploads/content', 'public');
                $data[$fieldName] = 'storage/' . $path;
            }
        }
        
        $this->contentRepository->save($contentType, $data);
        
        // Invalidate Cache
        Cache::forget("content.{$contentType}");
        
        // If this content type corresponds to a Page, invalidate that page cache too
        $this->clearPageCache($contentType);
    }

    private function clearPageCache(string $contentType): void
    {
        // Map content types to page names
        $map = [
            'about-main' => 'about',
            'home-about' => 'about',
            'contact-info' => 'contact'
        ];

        if (isset($map[$contentType])) {
            Cache::forget("page.{$map[$contentType]}");
        }
    }

    private function getImageFields($contentType)
    {
        $mappings = [
            'home-hero' => [
                'hero_image' => 'hero_image_file'
            ],
            'about-main' => [
                'about_image' => 'about_image_file'
            ],
            'home-about' => [
                'about_image' => 'about_image_file'
            ],
            'contact-info' => [
                'contact_logo' => 'contact_logo_file'
            ],
            'site-info' => [
                'site_logo' => 'site_logo_file',
                'site_favicon' => 'site_favicon_file'
            ]
        ];
        
        return $mappings[$contentType] ?? [];
    }
    
    public function getValidationRules($contentType) 
    {
         // Moved from Controller
         $rules = [
            'home-hero' => [
                'hero_title' => 'required|string|max:255',
                'hero_subtitle' => 'required|string|max:500',
                'hero_button_text' => 'required|string|max:50',
                'hero_image' => 'nullable|string',
                'hero_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            'home-features' => [
                'features_title' => 'required|string|max:255',
                'features_subtitle' => 'required|string|max:500',
                'features' => 'required|array|min:1',
                'features.*.title' => 'required|string|max:255',
                'features.*.description' => 'required|string|max:500',
            ],
            'about-main' => [
                'about_title' => 'required|string|max:255',
                'about_subtitle' => 'required|string|max:255',
                'about_description' => 'required|string|max:2000',
                'about_image' => 'nullable|string',
                'about_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'about_content' => 'nullable|string',
                'features' => 'nullable|array',
                'features.*.title' => 'nullable|string|max:255',
                'features.*.description' => 'nullable|string|max:500',
            ],
            'home-about' => [
                'about_title' => 'required|string|max:255',
                'about_subtitle' => 'required|string|max:255',
                'about_description' => 'required|string|max:2000',
                'about_image' => 'nullable|string',
                'about_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'about_content' => 'nullable|string',
                'features' => 'nullable|array',
                'features.*.title' => 'nullable|string|max:255',
                'features.*.description' => 'nullable|string|max:500',
            ],
            'contact-info' => [
                'contact_title' => 'required|string|max:255',
                'contact_description' => 'required|string|max:500',
                'contact_phone' => 'required|string|max:50',
                'contact_email' => 'required|email|max:255',
                'contact_address' => 'required|string|max:500',
                'contact_logo' => 'nullable|string|max:255',
                'contact_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ],
            'site-info' => [
                'site_name' => 'required|string|max:255',
                'site_description' => 'required|string|max:500',
                'site_keywords' => 'required|string|max:255',
                'site_logo' => 'nullable|string',
                'site_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'site_favicon' => 'nullable|string',
                'site_favicon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:1024',
            ]
        ];
        
        return $rules[$contentType] ?? [];
    }
}
