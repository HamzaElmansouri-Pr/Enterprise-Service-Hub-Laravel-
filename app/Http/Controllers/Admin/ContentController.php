<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Page;

class ContentController extends Controller
{
    /**
     * Display a listing of the content sections
     */
    public function index()
    {
        return view('admin.content.index');
    }
    
    /**
     * Show the form for editing the specified content
     */
    public function edit($contentType)
    {
        // Load content from storage or database
        $content = $this->getContent($contentType);
        
        return view('admin.content.edit', compact('contentType', 'content'));
    }
    
    /**
     * Update the specified content
     */
    public function update(Request $request, $contentType)
    {
        $validated = $request->validate($this->getValidationRules($contentType));
        
        // Save content to storage or database
        // Handle file uploads where applicable
        if (in_array($contentType, ['about-main', 'home-about']) && $request->hasFile('about_image_file')) {
            $path = $request->file('about_image_file')->store('uploads/pages', 'public');
            // Prefer stored path over URL
            $validated['about_image'] = 'storage/' . $path;
        }

        $this->saveContent($contentType, $validated);
        
        return redirect()->route('admin.content.index')
            ->with('success', 'Content updated successfully!');
    }
    
    /**
     * Get content for a specific type
     */
    private function getContent($contentType)
    {
        // Try to load from Page model where applicable
        if (in_array($contentType, ['about-main', 'home-about'])) {
            $page = Page::getByName('about');
            if ($page) {
                $meta = $page->meta_data ?? [];
                return [
                    'about_title' => $page->title,
                    'about_subtitle' => $page->subtitle,
                    'about_description' => $page->description,
                    'about_image' => $page->image ? (str_starts_with($page->image, 'http') ? $page->image : asset($page->image)) : null,
                    'about_content' => $page->content,
                    'features' => $meta['features'] ?? [],
                ];
            }
        }
        // Otherwise, fall back to defaults
        $defaultContent = [
            'home-hero' => [
                'hero_title' => 'The complete CRM solution built for your success',
                'hero_subtitle' => 'All your customer data, tools, and insights in one unified platform.',
                'hero_button_text' => 'try for free',
                'hero_image' => asset('assets/img/home-3/hero/hero-image.png'),
            ],
            'home-features' => [
                'features_title' => 'SupremeIT key benefits',
                'features_subtitle' => 'Flexible experiences that scale with your growth and deliver faster time to value',
                'features' => [
                    [
                        'title' => 'All-in-One CRM',
                        'description' => 'Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.'
                    ],
                    [
                        'title' => 'Affordable',
                        'description' => 'Make the most of SupremeIT\'s modern features & integrations, easy implementation and great support at an affordable price.'
                    ],
                    [
                        'title' => 'Next-Generation',
                        'description' => 'Automate your sales, marketing, and service in one platform. Avoid data leaks and enable consistent messaging.'
                    ]
                ]
            ],
            'about-main' => [
                'about_title' => 'Deliver unforgettable customer experiences',
                'about_subtitle' => 'Why SupremeIT crm',
                'about_description' => 'There are many variations of passages of Lorem Ipsum available...',
                'about_image' => asset('assets/img/new-add/crm-img.png'),
                'about_content' => null,
                'features' => [
                    ['title' => 'All-in-One CRM', 'description' => 'Automate your sales, marketing, and service in one platform.'],
                    ['title' => 'Affordable', 'description' => 'Make the most of SupremeIT\'s modern features & integrations.'],
                    ['title' => 'Next-Generation', 'description' => 'Avoid data leaks and enable consistent messaging.'],
                ],
            ],
            'home-about' => [
                'about_title' => 'Deliver unforgettable customer experiences',
                'about_subtitle' => 'Why SupremeIT crm',
                'about_description' => 'There are many variations of passages of Lorem Ipsum available...',
                'about_image' => asset('assets/img/new-add/crm-img.png'),
                'about_content' => null,
                'features' => [
                    ['title' => 'All-in-One CRM', 'description' => 'Automate your sales, marketing, and service in one platform.'],
                    ['title' => 'Affordable', 'description' => 'Make the most of SupremeIT\'s modern features & integrations.'],
                    ['title' => 'Next-Generation', 'description' => 'Avoid data leaks and enable consistent messaging.'],
                ],
            ],
            'contact-info' => [
                'contact_title' => 'Ready to get started?',
                'contact_description' => 'Contact us today to learn more about how SupremeIT can help your business grow.',
                'contact_phone' => '+1 (555) 123-4567',
                'contact_email' => 'info@supremeit.com',
                'contact_address' => "123 Business Street\nCity, State 12345",
            ],
            'site-info' => [
                'site_name' => 'SupremeIT',
                'site_description' => 'SupremeIT provides cutting-edge technology solutions to help businesses grow and succeed in the digital world.',
                'site_keywords' => 'CRM, business solutions, technology',
                'site_logo' => asset('assets/img/logo/theme-logo-2.svg'),
                'site_favicon' => asset('assets/img/favicon.svg'),
            ]
        ];
        
        return $defaultContent[$contentType] ?? [];
    }
    
    /**
     * Get validation rules for content type
     */
    private function getValidationRules($contentType)
    {
        $rules = [
            'home-hero' => [
                'hero_title' => 'required|string|max:255',
                'hero_subtitle' => 'required|string|max:500',
                'hero_button_text' => 'required|string|max:50',
                'hero_image' => 'nullable|url',
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
            ],
            'site-info' => [
                'site_name' => 'required|string|max:255',
                'site_description' => 'required|string|max:500',
                'site_keywords' => 'required|string|max:255',
                'site_logo' => 'nullable|url',
                'site_favicon' => 'nullable|url',
            ]
        ];
        
        return $rules[$contentType] ?? [];
    }
    
    /**
     * Save content for a specific type
     */
    private function saveContent($contentType, $data)
    {
        if (in_array($contentType, ['about-main', 'home-about'])) {
            $page = Page::firstOrCreate(['name' => 'about'], ['is_active' => true]);
            if (isset($data['about_title'])) $page->title = $data['about_title'];
            if (isset($data['about_subtitle'])) $page->subtitle = $data['about_subtitle'];
            if (isset($data['about_description'])) $page->description = $data['about_description'];
            if (!empty($data['about_image'])) $page->image = $data['about_image'];
            if (isset($data['about_content'])) $page->content = $data['about_content'];
            $meta = $page->meta_data ?? [];
            if (isset($data['features'])) $meta['features'] = $data['features'];
            $page->meta_data = $meta;
            $page->save();
            return;
        }
        // Fallback demo behavior
        session(['content_' . $contentType => $data]);
    }
}