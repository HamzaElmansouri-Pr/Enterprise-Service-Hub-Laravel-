<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_access_dashboard()
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.dashboard.index');
        $response->assertSee('Admin Dashboard');
    }

    public function test_non_admin_cannot_access_dashboard()
    {
        $user = User::factory()->create([
            'role' => 'user', 
        ]);

        $response = $this->actingAs($user)
                         ->get(route('admin.dashboard'));

        $response->assertStatus(403);
    }

    public function test_guest_redirected_to_login()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertStatus(302);
        // Expect standard login redirection
        $response->assertRedirect(route('login'));
    }
}
