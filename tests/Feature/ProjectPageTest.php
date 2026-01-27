<?php

namespace Tests\Feature;

use App\Models\Project;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_projects_index_page_loads(): void
    {
        Project::factory()->create([
            'title' => 'Test Project',
            'is_active' => true,
        ]);

        $response = $this->get('/projects');

        $response->assertStatus(200);
        $response->assertSee('Test Project');
    }

    public function test_project_detail_page_loads(): void
    {
        $project = Project::factory()->create([
            'title' => 'Detail Project',
            'slug' => 'detail-project',
            'is_active' => true,
        ]);

        $response = $this->get('/projects/detail-project');

        $response->assertStatus(200);
        $response->assertSee('Detail Project');
    }
}
