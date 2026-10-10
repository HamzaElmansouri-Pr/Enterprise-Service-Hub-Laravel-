<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Project;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_active' => true,
        ]);
    }

    public function test_admin_can_view_categories_index(): void
    {
        Category::create([
            'name' => ['en' => 'Web App', 'ar' => 'تطبيق ويب'],
            'slug' => 'web-app',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->get(route('admin.categories.index'));

        $response->assertStatus(200);
        $response->assertSee('Web App');
    }

    public function test_admin_can_view_edit_project_with_categories_component(): void
    {
        $cat = Category::create([
            'name' => ['en' => 'Design & UI'],
            'slug' => 'design-ui',
        ]);

        $project = Project::create([
            'title' => ['en' => 'Sample Project'],
            'slug' => 'sample-project',
            'description' => ['en' => 'Sample description'],
            'is_active' => true,
        ]);

        $project->categories()->attach($cat->id);

        $response = $this->actingAs($this->admin)->get(route('admin.projects.edit', $project));
        $response->assertStatus(200);
        $response->assertSee('Design &amp; UI', false);
        $response->assertSee('category-pill-btn', false);
    }

    public function test_admin_can_create_category(): void
    {
        $response = $this->actingAs($this->admin)->post(route('admin.categories.store'), [
            'name' => [
                'en' => 'Cloud Architecture',
                'ar' => 'هندسة السحابة',
            ],
            'slug' => 'cloud-architecture',
            'description' => [
                'en' => 'Cloud solutions and infra',
            ],
            'order_index' => 5,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'slug' => 'cloud-architecture',
        ]);
    }

    public function test_admin_can_update_category(): void
    {
        $category = Category::create([
            'name' => ['en' => 'Initial Name'],
            'slug' => 'initial-name',
        ]);

        $response = $this->actingAs($this->admin)->put(route('admin.categories.update', $category), [
            'name' => ['en' => 'Updated Name'],
            'slug' => 'updated-name',
            'order_index' => 1,
            'is_active' => true,
        ]);

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'slug' => 'updated-name',
        ]);
    }

    public function test_admin_can_delete_category(): void
    {
        $category = Category::create([
            'name' => ['en' => 'To Delete'],
            'slug' => 'to-delete',
        ]);

        $response = $this->actingAs($this->admin)->delete(route('admin.categories.destroy', $category));

        $response->assertRedirect(route('admin.categories.index'));
        $this->assertDatabaseMissing('categories', [
            'id' => $category->id,
        ]);
    }

    public function test_admin_can_toggle_category_status(): void
    {
        $category = Category::create([
            'name' => ['en' => 'Toggle Cat'],
            'slug' => 'toggle-cat',
            'is_active' => true,
        ]);

        $response = $this->actingAs($this->admin)->patch(route('admin.categories.toggle-status', $category));

        $response->assertRedirect();
        $this->assertFalse($category->fresh()->is_active);
    }

    public function test_project_can_have_multiple_categories_or_null(): void
    {
        \Illuminate\Support\Facades\Queue::fake();

        $cat1 = Category::create([
            'name' => ['en' => 'Frontend'],
            'slug' => 'frontend',
        ]);
        $cat2 = Category::create([
            'name' => ['en' => 'Backend'],
            'slug' => 'backend',
        ]);

        // 1. Create project with multiple categories
        $projectData = [
            'title' => ['en' => 'Fullstack Project'],
            'slug' => 'fullstack-project',
            'description' => ['en' => 'Fullstack description'],
            'meta_description' => ['en' => 'Meta description'],
            'category_ids' => [$cat1->id, $cat2->id],
            'categories_submitted' => 1,
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.projects.store'), $projectData);
        $response->assertRedirect(route('admin.projects.index'));

        $project = Project::where('slug', 'fullstack-project')->first();
        $this->assertNotNull($project);
        $this->assertCount(2, $project->categories);
        $this->assertTrue($project->categories->contains($cat1->id));
        $this->assertTrue($project->categories->contains($cat2->id));

        // 2. Update project to have 0 categories (null)
        $updateData = [
            'title' => ['en' => 'Fullstack Project'],
            'description' => ['en' => 'Fullstack description'],
            'categories_submitted' => 1, // none checked
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.projects.update', $project), $updateData);
        $response->assertRedirect(route('admin.projects.index'));

        $project->refresh();
        $this->assertCount(0, $project->categories);
        $this->assertNull($project->category);

        // 3. Update project to have 1 category
        $updateData2 = [
            'title' => ['en' => 'Fullstack Project'],
            'description' => ['en' => 'Fullstack description'],
            'category_ids' => [$cat1->id],
            'categories_submitted' => 1,
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.projects.update', $project), $updateData2);
        $response->assertRedirect(route('admin.projects.index'));

        $project->refresh();
        $this->assertCount(1, $project->categories);
        $this->assertEquals('Frontend', $project->categories->first()->name);
    }
}
