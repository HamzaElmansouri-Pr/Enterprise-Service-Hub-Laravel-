<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SettingsController extends Controller
{
    use AuthorizesRequests;

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
    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }
            
            $path = $request->file('image')->store('uploads/profiles', 'public');
            $validated['image'] = $path;
        }

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
    public function updatePassword(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

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
        
        if ($user->image && Storage::disk('public')->exists($user->image)) {
            Storage::disk('public')->delete($user->image);
        }
        
        $user->update(['image' => null]);

        return redirect()->route('admin.settings.edit-profile')
            ->with('success', 'Profile image deleted successfully!');
    }
}