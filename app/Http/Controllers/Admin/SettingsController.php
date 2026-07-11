<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\CloudinaryUploadService;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateAdminPasswordRequest;

class SettingsController extends Controller
{
    use AuthorizesRequests;

    protected CloudinaryUploadService $uploadService;

    public function __construct(CloudinaryUploadService $uploadService)
    {
        $this->uploadService = $uploadService;
    }

    /**
     * Display the settings index page
     */
    public function index()
    {
        if (!Auth::user()->isAdmin()) {
            abort(403, 'Only administrators can access site settings.');
        }
        $user = Auth::user();
        return view('admin.settings.index', compact('user'));
    }

    /**
     * Show the profile edit form
     */
    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.settings.edit-profile', compact('user'));
    }

    /**
     * Update the user profile
     */
    public function updateProfile(UpdateProfileRequest $request)
    {
        $user = Auth::user();
        
        $validated = $request->validated();

        if (!empty($validated['image_url'])) {
            if ($user->image !== $validated['image_url']) {
                $this->uploadService->delete($user->image);
            }

            $validated['image'] = $validated['image_url'];
        }

        // Handle image upload
        if ($request->hasFile('image')) {
            $this->uploadService->delete($user->image);
            $validated['image'] = $this->uploadService->upload($request->file('image'), 'profiles');
        }

        unset($validated['image_url']);

        $user->update($validated);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the password change form
     */
    public function editPassword()
    {
        return view('admin.settings.edit-password');
    }

    /**
     * Update the user password
     */
    public function updatePassword(UpdateAdminPasswordRequest $request)
    {
        $user = Auth::user();
        
        $validated = $request->validated();

        // Check current password
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->withErrors([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'Password updated successfully!');
    }

    /**
     * Delete user profile image
     */
    public function deleteImage()
    {
        $user = Auth::user();
        
        $this->uploadService->delete($user->image);
        return redirect()->route('admin.settings.edit-profile')
            ->with('success', 'Profile image deleted successfully!');
    }

    public function twoFactor()
    {
        return view('admin.settings.2fa');
    }

    /**
     * Update the user's theme preference via AJAX.
     */
    public function updateTheme(Request $request)
    {
        $validated = $request->validate([
            'theme' => 'required|in:light,dark,system'
        ]);

        $user = Auth::user();
        $user->theme_preference = $validated['theme'];
        $user->save();

        return response()->json(['success' => true]);
    }

    /**
     * Update user preferences (like saved views) via AJAX.
     */
    public function updatePreferences(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:100',
            'value' => 'nullable' // can be array, string, or null to delete
        ]);

        $user = Auth::user();
        $prefs = $user->preferences ?? [];

        if (is_null($validated['value'])) {
            unset($prefs[$validated['key']]);
        } else {
            $prefs[$validated['key']] = $validated['value'];
        }

        $user->preferences = $prefs;
        $user->save();

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'preferences' => $prefs]);
        }

        return redirect()->back()->with('success', 'View deleted successfully.');
    }
}