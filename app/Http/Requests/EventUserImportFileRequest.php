<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUserImportFileRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'import_file' => 'required|file|mimes:csv,txt|max:4096'
        ];
    }

    public function messages(): array
    {
        return [
            'import_file.required' => __('You must select file for import.'),
            'import_file.file' => __('This field must be a :mime file', ['mime' => 'CSV or TXT']),
            'import_file.mimes' => __('File must be in :mime format', ['mime' => 'CSV or TXT']),
            'import_file.max' => __('Maximum file size is :size', ['size' => '4 MB'])
        ];
    }
}
