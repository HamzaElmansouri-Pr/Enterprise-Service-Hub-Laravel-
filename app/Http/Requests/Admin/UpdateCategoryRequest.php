<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category') instanceof \App\Models\Category 
            ? $this->route('category')->id 
            : $this->route('category');

        return [
            'name' => 'required|array',
            'name.en' => 'required|string|max:255',
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($categoryId)],
            'description' => 'nullable|array',
            'is_active' => 'boolean',
            'order_index' => 'integer|min:0',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'order_index' => (int) $this->input('order_index', 0),
        ]);
    }
}
