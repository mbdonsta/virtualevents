<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadMediaFileRequest extends FormRequest
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
            'file' => 'required|file|mimes:jpg,png|max:2048'
        ];
    }

    public function messages(): array
    {
        return [
            'file.required' => __('You must select file for import.'),
            'file.file' => __('This field must be a :mime file', ['mime' => 'JPG or PNG']),
            'file.mimes' => __('File must be in :mime format', ['mime' => 'JPG or PNG']),
            'file.max' => __('Maximum file size is :size', ['size' => '2 MB'])
        ];
    }
}
