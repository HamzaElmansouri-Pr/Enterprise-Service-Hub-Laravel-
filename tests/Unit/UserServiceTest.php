<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Exception;

class UserServiceTest extends TestCase
{
    use RefreshDatabase;

    protected UserService $userService;

    protected function setUp(): void
    {
        parent::setUp();
        // Since UserService is bound in the container (or its dependencies are),
        // we can just resolve it.
        $this->userService = $this->app->make(UserService::class);
    }

    /**
     * Test role assignment forces the role attribute correctly.
     */
    public function test_assign_role()
    {
        $user = User::factory()->create(['role' => 'user']);
        
        $result = $this->userService->assignRole($user->id, 'admin');
        
        $this->assertTrue($result);
        $this->assertEquals('admin', $user->fresh()->role);
    }

    /**
     * Test assign role fails gracefully for non-existent user.
     */
    public function test_assign_role_non_existent_user()
    {
        $result = $this->userService->assignRole(999, 'admin');
        $this->assertFalse($result);
    }

    /**
     * Test toggle active status.
     */
    public function test_toggle_active()
    {
        // Another user logs in to toggle someone else
        $admin = User::factory()->create();
        Auth::login($admin);

        $targetUser = User::factory()->create(['is_active' => true]);

        $this->userService->toggleActive($targetUser->id);

        $this->assertFalse($targetUser->fresh()->is_active);

        $this->userService->toggleActive($targetUser->id);

        $this->assertTrue($targetUser->fresh()->is_active);
    }

    /**
     * Test toggle active throws exception when trying to deactivate self.
     */
    public function test_toggle_active_throws_exception_on_self()
    {
        $user = User::factory()->create();
        Auth::login($user);

        $this->expectException(Exception::class);
        $this->expectExceptionMessage('You cannot deactivate your own account.');

        $this->userService->toggleActive($user->id);
    }

    /**
     * Test deleting a user via the service.
     * (Self-delete protection is in the controller as per comments, so service should just delete).
     */
    public function test_delete_user()
    {
        $user = User::factory()->create();
        
        $result = $this->userService->deleteUser($user->id);
        
        $this->assertTrue($result);
        $this->assertNull(User::find($user->id));
    }
}
