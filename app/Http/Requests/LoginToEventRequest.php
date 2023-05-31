<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginToEventRequest extends FormRequest
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
            'email' => 'required',
            'access_number' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => __('Email address is required field.'),
            'access_number.required' => __('Access number field is required.')
        ];
    }
}
