<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Page;
use App\Repositories\Interfaces\ContentRepositoryInterface;

class ContentRepository implements ContentRepositoryInterface
{
    public function get(string $contentType): array
    {
        if (in_array($contentType, ['about-main', 'home-about'])) {
            $page = Page::where('name', 'about')->first();
            if ($page) {
                // Mapping DB fields back to form fields
                return [
                    'about_title' => $page->title,
                    'about_subtitle' => $page->subtitle,
                    'about_description' => $page->description,
                    'about_image' => $page->image,
                    'about_content' => $page->content,
                    'features' => $page->meta_data['features'] ?? []
                ];
            }
        }
        
        if ($contentType === 'contact-info') {
             $page = Page::where('name', 'contact')->first();
             if ($page) {
                 return [
                    'contact_title' => $page->title,
                    'contact_description' => $page->description,
                    'contact_phone' => $page->contact_phone,
                    'contact_email' => $page->contact_email,
                    'contact_address' => $page->contact_address,
                    'contact_logo' => $page->contact_logo,
                 ];
             }
        }

        return session('content_' . $contentType, []);
    }

    public function save(string $contentType, array $data): void
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

        if ($contentType === 'contact-info') {
             $page = Page::firstOrCreate(['name' => 'contact'], ['is_active' => true]);
             if (isset($data['contact_title'])) $page->title = $data['contact_title'];
             if (isset($data['contact_description'])) $page->description = $data['contact_description'];
             if (isset($data['contact_phone'])) $page->contact_phone = $data['contact_phone'];
             if (isset($data['contact_email'])) $page->contact_email = $data['contact_email'];
             if (isset($data['contact_address'])) $page->contact_address = $data['contact_address'];
             if (isset($data['contact_logo'])) $page->contact_logo = $data['contact_logo'];
             $page->save();
             return;
        }

        session(['content_' . $contentType => $data]);
    }

    public function getPageByName(string $name)
    {
        return Page::getByName($name);
    }
}
