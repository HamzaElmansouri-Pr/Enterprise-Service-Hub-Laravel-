<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTcRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email|max:255',
            'description' => 'required|string|max:2000',
            'service_id' => 'nullable|exists:services,id',
            'attached_file' => 'nullable|file|mimes:pdf,doc,docx,txt|max:10240', // 10MB max
        ];
    }
}
