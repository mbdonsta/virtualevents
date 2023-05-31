<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionStandStoreRequest extends FormRequest
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
            'exhibition_group_id' => 'required|integer',
            'name' => 'required|string',
            'media_file_id' => 'nullable|integer',
            'featured_image_id' => 'nullable|integer',
//            'layout_style' => 'required|integer'
        ];
    }

    public function messages(): array
    {
        return [
            'exhibition_group_id.required' => __(':field is a required field.', ['field' => 'Exhibition group']),
            'layout_style.integer' => __('This field value must be an integer.'),
            'name.required' => __(':field is a required field.', ['field' => 'Stand name']),
            'name.string' => __(':field must be a string.', ['field' => 'Stand name']),
            'layout_style.required' => __(':field is a required field.', ['field' => 'Stand layout']),
            'media_file_id.integer' => __('This field value must be an integer.')
        ];
    }
}
