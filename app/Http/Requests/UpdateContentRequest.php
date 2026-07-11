<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
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
        $cmsManager = app(\App\Services\CMSManager::class);
        $type = $this->route('type');
        
        $rules = $cmsManager->getValidationRules($type);
        
        if ($this->has('is_active_toggle')) {
            $rules['is_active'] = 'nullable|boolean';
        }

        return $rules;
    }
}
