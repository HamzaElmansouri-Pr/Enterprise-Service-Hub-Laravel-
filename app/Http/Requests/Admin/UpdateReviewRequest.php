<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_name' => 'required|array',
            'client_name.en' => 'required|string|max:255',
            'client_position' => 'nullable|array',
            'client_company' => 'nullable|string|max:255',
            'client_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'client_image_url' => 'nullable|url|max:2048',
            'review_text' => 'required|array',
            'review_text.en' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'project_type' => 'nullable|string|max:255',
            'is_featured' => 'boolean',
            'is_approved' => 'boolean',
            'sort_order' => 'nullable|integer',
        ];
    }
}
