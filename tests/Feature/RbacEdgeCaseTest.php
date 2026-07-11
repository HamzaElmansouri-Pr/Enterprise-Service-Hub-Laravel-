<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RbacEdgeCaseTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test editors cannot access admin-only routes like user management.
     */
    public function test_editor_cannot_access_user_management()
    {
        $editor = User::factory()->create(['role' => 'editor', 'is_active' => true, 'two_factor_secret' => 'dummy']);

        $this->actingAs($editor);

        // Accessing user index should fail with 403
        $response = $this->get('/admin/users');
        $response->assertStatus(403);
    }

    /**
     * Test editors can access their own edit profile page.
     */
    public function test_editor_can_access_own_profile()
    {
        $editor = User::factory()->create(['role' => 'editor', 'is_active' => true, 'two_factor_secret' => 'dummy']);

        $this->actingAs($editor);

        $response = $this->get('/admin/users/' . $editor->id . '/edit');
        $response->assertStatus(200);
    }

    /**
     * Test deactivated users are immediately logged out from admin area.
     */
    public function test_deactivated_user_is_blocked_from_admin()
    {
        $deactivatedAdmin = User::factory()->create(['role' => 'admin', 'is_active' => false, 'two_factor_secret' => 'dummy']);

        $this->actingAs($deactivatedAdmin);

        $response = $this->get('/admin');
        
        // AdminMiddleware should abort with 403
        $response->assertStatus(403);

        // Ensure user is logged out
        $this->assertGuest();
    }

    /**
     * Test role escalation: Editor attempts to update their own role to Admin.
     */
    public function test_role_escalation_is_blocked()
    {
        $editor = User::factory()->create(['role' => 'editor', 'is_active' => true, 'two_factor_secret' => 'dummy']);

        $this->actingAs($editor);

        $payload = [
            'name' => 'Editor Name',
            'email' => $editor->email,
            'role' => 'admin', // Escalation attempt
        ];

        // The update itself might succeed (200/302) or fail (403), 
        // but the crucial part is the role should NOT change.
        $this->put('/admin/users/' . $editor->id, $payload);

        $this->assertEquals('editor', $editor->fresh()->role);
    }
}
