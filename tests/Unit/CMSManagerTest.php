<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Page;
use App\Models\Section;
use App\Services\CMSManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CMSManagerTest extends TestCase
{
    use RefreshDatabase;

    protected CMSManager $cmsManager;

    protected function setUp(): void
    {
        parent::setUp();
        $this->cmsManager = $this->app->make(CMSManager::class);
    }

    /**
     * Test CMSManager::resolvePage properly maps page sections to the resulting object.
     */
    public function test_resolve_page_maps_sections()
    {
        // 1. Create a page
        $page = Page::create([
            'title' => 'Home Page',
            'slug' => 'home',
            'is_active' => true,
        ]);

        // 2. Create a hero section for this page
        $heroSection = Section::create([
            'page_id' => $page->id,
            'name' => 'Hero Section',
            'type' => 'home-hero',
            'is_active' => true,
            'order_index' => 1,
        ]);

        // Add content blocks to the hero section
        $heroSection->contentBlocks()->create([
            'key' => 'hero_title',
            'type' => 'text',
            'content' => 'Welcome to the Hub',
        ]);
        $heroSection->contentBlocks()->create([
            'key' => 'hero_subtitle',
            'type' => 'text',
            'content' => 'The best services',
        ]);

        // 3. Create an about section
        $aboutSection = Section::create([
            'page_id' => $page->id,
            'name' => 'About Section',
            'type' => 'home-about',
            'is_active' => true,
            'order_index' => 2,
        ]);

        $aboutSection->contentBlocks()->create([
            'key' => 'about_title',
            'type' => 'text',
            'content' => 'About Us',
        ]);
        
        $featuresJson = json_encode([
            ['title' => 'Feature 1'],
            ['title' => 'Feature 2']
        ]);
        $aboutSection->contentBlocks()->create([
            'key' => 'features',
            'type' => 'json',
            'content' => $featuresJson,
        ]);

        // 4. Resolve the page
        $resolved = $this->cmsManager->resolvePage('home');

        // Assertions for hero section
        $this->assertEquals('Welcome to the Hub', $resolved->heroTitle);
        $this->assertEquals('The best services', $resolved->heroSubtitle);
        
        // Assertions for about section
        $this->assertObjectHasProperty('about', $resolved);
        $this->assertEquals('About Us', $resolved->about->title);
        $this->assertArrayHasKey('features', $resolved->about->meta_data);
        $this->assertCount(2, $resolved->about->meta_data['features']);
        $this->assertEquals('Feature 1', $resolved->about->meta_data['features'][0]['title']);
    }
    
    /**
     * Test fallback resolution
     */
    public function test_resolve_page_with_fallbacks()
    {
        // 1. Create a page with no sections
        $page = Page::create([
            'title' => 'Empty Page',
            'slug' => 'empty',
            'is_active' => true,
        ]);
        
        $fallbacks = [
            'heroTitle' => 'Fallback Hero',
            'about' => [
                'title' => 'Fallback About'
            ]
        ];
        
        $resolved = $this->cmsManager->resolvePage('empty', $fallbacks);
        
        $this->assertEquals('Fallback Hero', $resolved->heroTitle);
        $this->assertObjectHasProperty('about', $resolved);
        $this->assertEquals('Fallback About', $resolved->about->title);
    }
}
