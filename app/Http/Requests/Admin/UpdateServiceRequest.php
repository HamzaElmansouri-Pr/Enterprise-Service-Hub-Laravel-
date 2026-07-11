<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
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
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('services', 'slug')->ignore($this->service)],
            'subtitle' => 'nullable|array',
            'description' => 'required|array',
            'description.en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_url' => 'nullable|url|max:2048',
            'icon' => 'nullable',
            'is_active' => 'boolean',
            'order_index' => 'integer|min:0',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
            'og_image' => 'nullable|image|max:2048',
            'og_image_url' => 'nullable|url|max:2048',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
