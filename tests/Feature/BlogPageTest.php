<?php

namespace Tests\Feature;

use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_blog_index_page_loads(): void
    {
        Blog::factory()->create([
            'title' => 'Test Blog Post',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $response = $this->get('/blog');

        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
    }

    public function test_blog_detail_page_loads(): void
    {
        $blog = Blog::factory()->create([
            'title' => 'Detailed Blog Post',
            'slug' => 'detailed-blog-post',
            'is_active' => true,
            'published_at' => now(),
        ]);

        $response = $this->get('/blog/detailed-blog-post');

        $response->assertStatus(200);
        $response->assertSee('Detailed Blog Post');
    }
}
