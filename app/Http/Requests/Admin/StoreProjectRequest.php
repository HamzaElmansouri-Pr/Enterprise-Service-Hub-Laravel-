<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:projects,slug',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'client' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:255',
            'completion_date' => 'nullable|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|string|max:2048',
            'is_active' => 'boolean',
            'order_index' => 'integer|min:0',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
            'og_image' => 'nullable|image|max:2048',
            'og_image_url' => 'nullable|string|max:2048',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
