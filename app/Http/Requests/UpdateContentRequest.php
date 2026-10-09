<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContentRequest extends FormRequest
{
    /**
     * Accept the legacy single-language form fields while storing CMS copy in
     * the same translatable shape used by the current editor components.
     */
    protected function prepareForValidation(): void
    {
        $rules = app(\App\Services\CMSManager::class)->getValidationRules((string) $this->route('type'));
        $input = $this->all();

        foreach ($rules as $field => $rule) {
            if (str_contains($field, '.')) {
                continue;
            }

            $ruleString = is_array($rule) ? implode('|', $rule) : $rule;
            if (!str_contains($ruleString, 'array') || !array_key_exists($field, $input) || is_array($input[$field])) {
                continue;
            }

            $input[$field] = ['en' => $input[$field]];
        }

        $this->replace($input);
    }

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
