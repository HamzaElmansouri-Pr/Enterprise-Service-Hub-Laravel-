<?php

namespace Tests\Feature;

use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminProjectTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        // Create admin user
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_projects_index()
    {
        Project::factory()->create(['title' => 'Test Project']);

        $response = $this->actingAs($this->admin)->get(route('admin.projects.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Project');
    }

    public function test_admin_can_create_project()
    {
        $data = [
            'title' => 'New Project',
            'description' => 'Project Description',
            'client' => 'Test Client',
            'category' => 'Web Dev',
            'is_active' => '1',
            'order_index' => 1,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $data);

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', ['title' => 'New Project', 'client' => 'Test Client']);
    }

    public function test_admin_can_update_project()
    {
        $project = Project::factory()->create();

        $data = [
            'title' => 'Updated Project',
            'description' => 'Updated Description',
            'client' => 'Updated Client',
            'category' => 'App Dev',
            'is_active' => '1',
            'order_index' => 2,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.projects.update', $project), $data);

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseHas('projects', ['id' => $project->id, 'title' => 'Updated Project']);
    }

    public function test_admin_can_delete_project()
    {
        $project = Project::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.projects.destroy', $project));

        $response->assertRedirect(route('admin.projects.index'));
        $this->assertDatabaseMissing('projects', ['id' => $project->id]);
    }
}
