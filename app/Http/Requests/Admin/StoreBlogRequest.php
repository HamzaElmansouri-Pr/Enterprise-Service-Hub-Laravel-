<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreBlogRequest extends FormRequest
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
            'slug' => 'nullable|string|max:255|unique:blogs,slug',
            'excerpt' => 'nullable|array',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured_image_url' => 'nullable|url|max:2048',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
            'categories_submitted' => 'nullable',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|array',
            'meta_description' => 'nullable|array',
            'og_image' => 'nullable|image|max:2048',
            'og_image_url' => 'nullable|url|max:2048',
        ];
    }

    protected function prepareForValidation()
    {
        $merge = [];
        if ($this->has('categories_submitted')) {
            $merge['category_ids'] = $this->input('category_ids', []);
        }
        if (!empty($merge)) {
            $this->merge($merge);
        }
    }
}
