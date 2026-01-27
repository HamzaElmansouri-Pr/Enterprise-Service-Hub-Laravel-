<?php

namespace Tests\Feature;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminBlogTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create admin user
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_blogs_index()
    {
        Blog::factory()->create(['title' => 'Test Blog Post', 'author_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->get(route('admin.blogs.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Blog Post');
    }

    public function test_admin_can_create_blog()
    {
        $data = [
            'title' => 'New Blog Post',
            'content' => 'Blog Content goes here...',
            'excerpt' => 'Short summary',
            'category' => 'Tech',
            'is_published' => '1',
            'published_at' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.blogs.store'), $data);

        $response->assertRedirect(route('admin.blogs.index'));
        $this->assertDatabaseHas('blogs', ['title' => 'New Blog Post', 'author_id' => $this->admin->id]);
    }

    public function test_admin_can_update_blog()
    {
        $blog = Blog::factory()->create(['author_id' => $this->admin->id]);

        $data = [
            'title' => 'Updated Blog Title',
            'content' => 'Updated Content',
            'excerpt' => 'Updated Excerpt',
            'category' => 'Life',
            'is_published' => '1',
            'published_at' => now()->format('Y-m-d'),
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.blogs.update', $blog), $data);

        $response->assertRedirect(route('admin.blogs.index'));
        $this->assertDatabaseHas('blogs', ['id' => $blog->id, 'title' => 'Updated Blog Title']);
    }

    public function test_admin_can_delete_blog()
    {
        $blog = Blog::factory()->create(['author_id' => $this->admin->id]);

        $response = $this->actingAs($this->admin)->delete(route('admin.blogs.destroy', $blog));

        $response->assertRedirect(route('admin.blogs.index'));
        $this->assertDatabaseMissing('blogs', ['id' => $blog->id]);
    }
}
