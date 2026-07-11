<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $blogId = $this->route('id') ?? $this->route('blog');
        if (is_object($blogId)) {
            $blogId = $blogId->id;
        }

        return [
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('blogs', 'slug')->ignore($blogId),
            ],
            'excerpt' => 'nullable|array',
            'content' => 'required|array',
            'content.en' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'featured_image_url' => 'nullable|url|max:2048',
            'author' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
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
}
