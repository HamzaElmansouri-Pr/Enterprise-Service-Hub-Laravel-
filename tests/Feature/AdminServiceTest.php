<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminServiceTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        // Create admin user
        $this->admin = User::factory()->create(['role' => 'admin']);
    }

    public function test_admin_can_view_services_index()
    {
        Service::factory()->create(['title' => 'Test Service']);

        $response = $this->actingAs($this->admin)->get(route('admin.services.index'));

        $response->assertStatus(200);
        $response->assertSee('Test Service');
    }

    public function test_admin_can_create_service()
    {
        $data = [
            'title' => 'New Service',
            'description' => 'Service Description',
            'is_active' => '1',
            'order_index' => 1,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.services.store'), $data);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['title' => 'New Service']);
    }

    public function test_admin_can_update_service()
    {
        $service = Service::factory()->create();

        $data = [
            'title' => 'Updated Service',
            'description' => 'Updated Description',
            'is_active' => '1',
            'order_index' => 2,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.services.update', $service), $data);

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseHas('services', ['id' => $service->id, 'title' => 'Updated Service']);
    }

    public function test_admin_can_delete_service()
    {
        $service = Service::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.services.destroy', $service));

        $response->assertRedirect(route('admin.services.index'));
        $this->assertDatabaseMissing('services', ['id' => $service->id]);
    }
}
