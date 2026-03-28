<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TcRequestSubmitRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Publicly accessible form
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'service_id' => 'nullable|exists:services,id',
            'description' => 'required|string|max:5000',
            'attached_file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'attachment.mimes' => 'The attachment must be a file of type: pdf, doc, docx, txt.',
            'attachment.max' => 'The attachment size must not exceed 10MB.',
        ];
    }
}
