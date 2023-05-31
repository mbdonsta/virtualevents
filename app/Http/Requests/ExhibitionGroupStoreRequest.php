<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionGroupStoreRequest extends FormRequest
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
            'title' => 'required|string',
            'columns' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __(':field is a required field.', ['field' => 'Group title']),
            'title.string' => __(':field must be a string.', ['field' => 'Group title']),
            'columns.required' => __(':field is a required field.', ['field' => 'Group layout']),
            'columns.integer' => __(':field is a required field.', ['field' => 'Group layout']),
        ];
    }
}
