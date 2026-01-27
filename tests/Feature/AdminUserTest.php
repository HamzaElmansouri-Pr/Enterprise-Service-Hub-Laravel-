<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AdminUserTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->admin = User::factory()->create([
            'role' => 'admin',
        ]);
    }

    public function test_admin_can_view_users_index()
    {
        User::factory()->create(['name' => 'Test User']);

        $response = $this->actingAs($this->admin)->get(route('admin.users.index'));

        $response->assertStatus(200);
        $response->assertSee('Test User');
    }

    public function test_admin_can_create_user()
    {
        $userData = [
            'name' => 'New User',
            'email' => 'newuser@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'editor',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)->post(route('admin.users.store'), $userData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['email' => 'newuser@example.com']);
    }

    public function test_admin_can_update_user()
    {
        $user = User::factory()->create();

        $updateData = [
            'name' => 'Updated User Name',
            'email' => $user->email,
            'role' => 'admin',
            'is_active' => true,
        ];

        $response = $this->actingAs($this->admin)->put(route('admin.users.update', $user), $updateData);

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'name' => 'Updated User Name']);
    }

    public function test_admin_can_delete_user()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $user));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_admin_cannot_delete_self()
    {
        $response = $this->actingAs($this->admin)->delete(route('admin.users.destroy', $this->admin));

        $response->assertRedirect(route('admin.users.index'));
        $this->assertDatabaseHas('users', ['id' => $this->admin->id]);
    }

    public function test_admin_can_toggle_user_active_status()
    {
        $user = User::factory()->create(['is_active' => true]);

        $response = $this->actingAs($this->admin)->patch(route('admin.users.toggle-active', $user));

        $response->assertRedirect();
        $this->assertDatabaseHas('users', ['id' => $user->id, 'is_active' => 0]);

        $response = $this->actingAs($this->admin)->patch(route('admin.users.toggle-active', $user));
        $this->assertDatabaseHas('users', ['id' => $user->id, 'is_active' => 1]);
    }
}
