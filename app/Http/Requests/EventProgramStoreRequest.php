<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventProgramStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'content' => 'json'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Day name is required field.'),
            'name.max' => __('Day name cannot be longer than 255 symbols'),
            'content.json' => __('Program content is invalid.'),
        ];
    }
}
