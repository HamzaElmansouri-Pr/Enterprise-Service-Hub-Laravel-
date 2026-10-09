<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::orderBy('id')->get();
        return view('admin.pages.index', compact('pages'));
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $validated = $request->validate([
            'title' => 'required|array',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
        ]);

        $page->update($validated);

        // Clear page caches
        $this->clearPageCaches($page->slug);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated successfully.');
    }

    protected function clearPageCaches(string $slug)
    {
        // CMSPageResolver keys localized pages by locale.
        Cache::forget("cms_page_{$slug}");
        Cache::forget("cms_page_{$slug}_loc");
        foreach (config('app.available_locales', ['en', 'fr', 'ar']) as $locale) {
            Cache::forget("cms_page_{$slug}_{$locale}");
        }
        
        // Clear related API endpoints
        Cache::forget("api_global_data"); // legacy key
        foreach (config('app.available_locales', ['en', 'fr', 'ar']) as $locale) {
            Cache::forget("api_global_data_{$locale}");
        }
        
        // Assuming HomeController, AboutController etc. might cache based on page
        switch($slug) {
            case 'home':
                Cache::forget('api_home_page');
                Cache::forget('api_home_page_loc');
                break;
            case 'about':
                Cache::forget('api_about_page');
                Cache::forget('api_about_page_loc');
                break;
            case 'contact':
                Cache::forget('api_contact_page');
                Cache::forget('api_contact_page_loc');
                break;
        }
    }
}
