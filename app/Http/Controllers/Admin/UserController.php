<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use App\DTOs\CreateUserData;
use App\DTOs\UpdateUserData;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;

class UserController extends Controller
{
    use AuthorizesRequests;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        $this->authorize('viewAny', User::class);
        $users = $this->userService->getAllUsers(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->authorize('create', User::class);
        return view('admin.users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class);
        
        $dto = CreateUserData::fromRequest($request);
        
        $this->userService->createUser($dto);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
         $this->authorize('view', $user);
         return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('admin.users.edit', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);
        
        $dto = UpdateUserData::fromRequest($request);
        
        $this->userService->updateUser($user->id, $dto);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        // Prevent deleting self (Check BEFORE authorization to allow redirect instead of 403)
        if (auth()->id() === $user->id) {
             return redirect()->route('admin.users.index')->with('error', 'You cannot delete yourself.');
        }

        $this->authorize('delete', $user);

        $this->userService->deleteUser($user->id);
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function toggleActive(User $user)
    {
        if (auth()->id() === $user->id) {
             return redirect()->back()->with('error', 'You cannot deactivate yourself.');
        }

        $this->authorize('update', $user);

        $this->userService->toggleActive($user->id);

        return redirect()->back()->with('success', 'User status updated successfully.');
    }
}
