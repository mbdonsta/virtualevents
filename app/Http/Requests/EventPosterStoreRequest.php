<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventPosterStoreRequest extends FormRequest
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
            'author' => 'required|max:255',
            'description' => 'required',
            'youtube_url' => 'max:255',
            'poster_image_id' => 'integer|nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'author.required' => __(':field is a required field.', ['field' => 'Author']),
            'author.max' => __(':field can not be more than 255 symbols.', ['field' => 'Poster author']),
            'description.required' => __(':field is a required field.', ['field' => 'Description']),
            'youtube_url.max' => __(':field can not be more than 255 symbols.', ['field' => 'URL']),
            'poster_image_id.integer' => __('This field value must be an integer.'),
        ];
    }
}
