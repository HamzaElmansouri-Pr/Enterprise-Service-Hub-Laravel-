<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSliderRequest extends FormRequest
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
            'title' => 'required|array',
            'title.en' => 'required|string|max:255',
            'subtitle' => 'nullable|array',
            'description' => 'nullable|array',
            'badge_text' => 'nullable|array',
            'button_text' => 'nullable|array',
            'button_url' => 'nullable|string|max:255',
            'secondary_button_text' => 'nullable|array',
            'secondary_button_url' => 'nullable|string|max:255',
            'alignment' => 'required|in:left,center,right',
            'overlay_opacity' => 'required|in:light,medium,dark',
            'text_theme' => 'required|in:light,dark',
            'video_url' => 'nullable|url|max:500',
            'title_color' => 'nullable|string|max:7',
            'subtitle_color' => 'nullable|string|max:7',
            'description_color' => 'nullable|string|max:7',
            // PHP upload_max_filesize is 2MB, so we limit validation to match
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_url' => 'nullable|string|max:2048',
            'is_active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->has('is_active'),
        ]);
    }
}
