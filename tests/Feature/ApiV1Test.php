<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Service;
use App\Models\Project;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\User;
use App\Models\TcRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Notification;

class ApiV1Test extends TestCase
{
    use RefreshDatabase;

    public function test_get_home_endpoint()
    {
        $response = $this->getJson('/api/v1/home');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'cms', 'sliders', 'services', 'projects', 'reviews', 'blogs', 'partners', 'sections'
                 ]);
    }

    public function test_get_about_endpoint()
    {
        $response = $this->getJson('/api/v1/about');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'page' => ['title', 'breadcrumb_title', 'image', 'about', 'stats', 'values', 'history', 'team']
                 ]);
    }

    public function test_get_services_index_endpoint()
    {
        Service::factory()->create(['is_active' => true]);
        
        $response = $this->getJson('/api/v1/services');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'services', 'pagination', 'page'
                 ]);
    }

    public function test_get_services_show_endpoint()
    {
        $service = Service::factory()->create(['is_active' => true]);
        
        $response = $this->getJson("/api/v1/services/{$service->slug}");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'service' => ['id', 'title', 'slug', 'description'],
                     'all_services'
                 ]);
    }

    public function test_get_projects_index_endpoint()
    {
        Project::factory()->create(['is_active' => true]);
        
        $response = $this->getJson('/api/v1/projects');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'projects', 'pagination', 'categories', 'page'
                 ]);
    }

    public function test_get_projects_show_endpoint()
    {
        $project = Project::factory()->create(['is_active' => true]);
        
        $response = $this->getJson("/api/v1/projects/{$project->slug}");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'project' => ['id', 'title', 'slug'],
                     'related_projects'
                 ]);
    }

    public function test_get_blogs_index_endpoint()
    {
        $user = User::factory()->create();
        Blog::factory()->create(['is_active' => true, 'author_id' => $user->id, 'published_at' => now()]);
        
        $response = $this->getJson('/api/v1/blogs');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'blogs', 'pagination', 'recent_blogs', 'page'
                 ]);
    }

    public function test_get_blogs_show_endpoint()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['is_active' => true, 'author_id' => $user->id, 'published_at' => now()]);
        
        $response = $this->getJson("/api/v1/blogs/{$blog->slug}");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'blog' => ['id', 'title', 'slug', 'content', 'excerpt', 'author'],
                     'recent_blogs'
                 ]);
    }

    public function test_get_blog_comments_index_endpoint()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['is_active' => true, 'author_id' => $user->id, 'published_at' => now()]);
        Comment::create([
            'blog_id' => $blog->id, 
            'name' => 'Test', 
            'email' => 'test@test.com', 
            'content' => 'Test', 
            'status' => 'approved'
        ]);
        
        $response = $this->getJson("/api/v1/blogs/{$blog->slug}/comments");
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'comments' => [
                         '*' => ['id', 'blog_id', 'parent_id', 'name', 'content', 'status', 'replies']
                     ]
                 ]);
    }

    public function test_post_blog_comments_store_endpoint()
    {
        $user = User::factory()->create();
        $blog = Blog::factory()->create(['is_active' => true, 'author_id' => $user->id, 'published_at' => now()]);
        
        $response = $this->postJson("/api/v1/blogs/{$blog->slug}/comments", [
            'name' => 'Tester',
            'email' => 'tester@example.com',
            'content' => 'This is a test comment.'
        ]);
        
        $response->assertStatus(201)
                 ->assertJsonStructure(['message', 'comment' => ['id', 'name', 'content', 'status']]);
    }

    public function test_get_contact_info_endpoint()
    {
        $response = $this->getJson('/api/v1/contact-info');
        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'page' => ['title', 'contact_address', 'contact_email', 'contact_phone'],
                     'services'
                 ]);
    }

    public function test_post_contact_validation_failure()
    {
        $response = $this->postJson('/api/v1/contact', []);
        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['name', 'email', 'message']);
    }

    public function test_post_contact_success()
    {
        Notification::fake();
        $response = $this->postJson('/api/v1/contact', [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'subject' => 'Help',
            'message' => 'Need help.',
            'phone' => '123123123'
        ]);
        $response->assertStatus(201)
                 ->assertJsonStructure(['message']);
    }

    public function test_post_tc_request_success()
    {
        Queue::fake();
        Notification::fake();
        $response = $this->postJson('/api/v1/tc-request', [
            'email' => 'tech@example.com',
            'description' => 'I need consultation.'
        ]);
        $response->assertStatus(201)
                 ->assertJsonStructure(['message']);
    }
}
