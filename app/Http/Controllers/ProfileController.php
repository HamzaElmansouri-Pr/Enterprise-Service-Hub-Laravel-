<?php

namespace App\Http\Controllers;

use App\DTOs\UpdateUserData;
use App\Http\Requests\ProfileUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Requests\DeleteUserRequest;

class ProfileController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $dto = UpdateUserData::fromArray($request->validated());
        $this->userService->updateUser($request->user()->id, $dto);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(DeleteUserRequest $request): RedirectResponse
    {
        $request->validated();

        $user = $request->user();

        Auth::logout();

        $this->userService->deleteUser($user->id);

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
