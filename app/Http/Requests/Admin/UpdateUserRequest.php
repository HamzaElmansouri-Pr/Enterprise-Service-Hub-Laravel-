<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $userId = $this->route('id') ?? $this->route('user'); // Handle route param variability
        
        // If route model binding is used, $this->route('user') is a User model.
        // If ID is used, it's an int.
        // Based on my refactor, I used ID in the route update?
        // Let's check UserController refactor. -> public function update(Request $request, int $id)
        // So route parameter is likely 'user' or 'id' depending on route definition, but I type hinted int $id.
        // Standard resource route uses {user}.
        
        // Safety check if it's an object
        if (is_object($userId)) {
            $userId = $userId->id;
        }

        return [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($userId),
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|string|in:admin,editor,user',
            'is_active' => 'boolean',
        ];
    }
}
