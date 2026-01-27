<?php

namespace Tests\Feature;

use App\Models\Service;
use App\Models\TcRequest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTcRequestTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_tc_requests_index()
    {
        $service = Service::factory()->create();
        TcRequest::factory()->create(['email' => 'test@example.com', 'service_id' => $service->id]);

        $response = $this->actingAs($this->admin)->get(route('admin.tc-requests.index'));

        $response->assertStatus(200);
        $response->assertSee('test@example.com');
    }

    public function test_admin_can_view_tc_request_details()
    {
        $tcRequest = TcRequest::factory()->create(['is_read' => false]);

        $response = $this->actingAs($this->admin)->get(route('admin.tc-requests.show', $tcRequest->id));

        $response->assertStatus(200);
        $this->assertDatabaseHas('tc_requests', ['id' => $tcRequest->id, 'is_read' => 1]);
    }

    public function test_admin_can_delete_tc_request()
    {
        $tcRequest = TcRequest::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.tc-requests.destroy', $tcRequest->id));

        $response->assertRedirect(route('admin.tc-requests.index'));
        $this->assertDatabaseMissing('tc_requests', ['id' => $tcRequest->id]);
    }

    public function test_admin_can_mark_tc_request_as_read()
    {
        $tcRequest = TcRequest::factory()->create(['is_read' => false]);

        $response = $this->actingAs($this->admin)->patch(route('admin.tc-requests.mark-read', $tcRequest->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('tc_requests', ['id' => $tcRequest->id, 'is_read' => 1]);
    }

    public function test_admin_can_mark_tc_request_as_unread()
    {
        $tcRequest = TcRequest::factory()->create(['is_read' => true]);

        $response = $this->actingAs($this->admin)->patch(route('admin.tc-requests.mark-unread', $tcRequest->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('tc_requests', ['id' => $tcRequest->id, 'is_read' => 0]);
    }

    public function test_admin_can_update_tc_request_status()
    {
        $tcRequest = TcRequest::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($this->admin)->patch(route('admin.tc-requests.update-status', $tcRequest->id), [
            'status' => 'completed'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('tc_requests', ['id' => $tcRequest->id, 'status' => 'completed']);
    }

    public function test_admin_can_mark_all_tc_requests_as_read()
    {
        TcRequest::factory()->count(3)->create(['is_read' => false]);

        $response = $this->actingAs($this->admin)->patch(route('admin.tc-requests.mark-all-read'));

        $response->assertRedirect();
        $this->assertEquals(0, TcRequest::where('is_read', false)->count());
    }
}
