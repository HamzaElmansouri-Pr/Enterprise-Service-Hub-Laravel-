<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class ContentController extends Controller
{
    public function index()
    {
        return view('admin.content.index');
    }

    public function edit(string $type)
    {
        list($pageSlug, $sectionKey) = $this->parseType($type);
        
        $page = Page::firstOrCreate(['slug' => $pageSlug], [
            'title' => ucwords(str_replace('-', ' ', $pageSlug)),
            'is_home' => $pageSlug === 'home',
        ]);
        
        $section = $page->sections()->firstOrCreate(['type' => $type], [
            'name' => ucwords(str_replace('-', ' ', $sectionKey)),
            'is_active' => true,
        ]);
        
        $content = $section->contentBlocks()->pluck('content', 'key')->toArray();
        
        // Decode JSON features if present
        if (isset($content['features'])) {
            $content['features'] = json_decode($content['features'], true);
        }
        
        return view("admin.content.edit", ['content' => $content, 'contentType' => $type]);
    }

    public function update(Request $request, string $type)
    {
        $rules = $this->getValidationRules($type);
        $validatedData = $request->validate($rules);
        
        list($pageSlug, $sectionKey) = $this->parseType($type);
        $page = Page::firstOrCreate(['slug' => $pageSlug], [
            'title' => ucwords(str_replace('-', ' ', $pageSlug)),
            'is_home' => $pageSlug === 'home',
        ]);
        
        $section = $page->sections()->firstOrCreate(['type' => $type], [
            'name' => ucwords(str_replace('-', ' ', $sectionKey)),
            'is_active' => true,
        ]);
        
        // Handle Files
        $imageFields = $this->getImageFields($type);
        foreach ($imageFields as $field => $fileField) {
            if ($request->hasFile($fileField)) {
                $file = $request->file($fileField);
                $path = $file->store('uploads/content', 'public');
                $validatedData[$field] = 'storage/' . $path;
            } else {
                // Keep existing if not provided
                $existing = $section->contentBlocks()->where('key', $field)->value('content');
                if ($existing) {
                    $validatedData[$field] = $existing;
                }
            }
            unset($validatedData[$fileField]);
        }

        foreach ($validatedData as $key => $value) {
            if (is_array($value)) {
                $value = json_encode($value);
            }
            
            $section->contentBlocks()->updateOrCreate(
                ['key' => $key],
                ['content' => $value]
            );
        }

        return redirect()->back()->with('success', 'Content updated successfully.');
    }

    private function parseType($type)
    {
        if (str_starts_with($type, 'home-')) {
            return ['home', str_replace('home-', '', $type)];
        }
        if (str_starts_with($type, 'about-')) {
            return ['about', str_replace('about-', '', $type)];
        }
        if (str_starts_with($type, 'contact-')) {
            return ['contact', str_replace('contact-', '', $type)];
        }
        return ['home', $type];
    }

    private function getValidationRules($type) 
    {
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
        ];
        return $rules[$type] ?? [];
    }

    private function getImageFields($type) {
        $map = [
            'home-hero' => ['hero_image' => 'hero_image_file'],
            'about-main' => ['about_image' => 'about_image_file'],
            'home-about' => ['about_image' => 'about_image_file'],
            'contact-info' => ['contact_logo' => 'contact_logo_file'],
        ];
        return $map[$type] ?? [];
    }
}
