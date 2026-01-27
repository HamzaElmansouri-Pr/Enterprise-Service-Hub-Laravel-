<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Page;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminContentTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
        
        $this->actingAs($this->admin);
    }

    public function test_admin_can_update_home_hero_content()
    {
        $data = [
            'hero_title' => 'New Hero Title',
            'hero_subtitle' => 'New Hero Subtitle',
            'hero_button_text' => 'Get Started',
        ];

        $response = $this->put(route('admin.content.update', 'home-hero'), $data);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('pages', ['slug' => 'home']);
        $page = Page::where('slug', 'home')->first();
        
        $section = $page->sections()->where('type', 'home-hero')->first();
        $this->assertNotNull($section);
        
        $this->assertDatabaseHas('content_blocks', [
            'section_id' => $section->id,
            'key' => 'hero_title',
            'content' => 'New Hero Title',
        ]);
    }

    public function test_admin_can_update_home_about_content()
    {
        $data = [
            'about_title' => 'New About Title',
            'about_subtitle' => 'New About Subtitle',
            'about_description' => 'New About Description',
        ];

        $response = $this->put(route('admin.content.update', 'home-about'), $data);

        $response->assertRedirect();
        
        $page = Page::where('slug', 'home')->first();
        $section = $page->sections()->where('type', 'home-about')->first();
        
        $this->assertDatabaseHas('content_blocks', [
            'section_id' => $section->id,
            'key' => 'about_title',
            'content' => 'New About Title',
        ]);
    }
    
    public function test_admin_can_update_about_main_content()
    {
        $data = [
            'about_title' => 'New Main About Title',
            'about_subtitle' => 'New Main About Subtitle',
            'about_description' => 'Description test',
        ];

        $response = $this->put(route('admin.content.update', 'about-main'), $data);

        $response->assertRedirect();
        
        $page = Page::where('slug', 'about')->first();
        $section = $page->sections()->where('type', 'about-main')->first();
        
        $this->assertDatabaseHas('content_blocks', [
            'section_id' => $section->id,
            'key' => 'about_title',
            'content' => 'New Main About Title',
        ]);
    }
}
