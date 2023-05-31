<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventUserStoreRequest extends FormRequest
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
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'firstname.required' => __('First name is a required field.'),
            'firstname.string' => __('First name must be a string'),
            'firstname.max' => __('First name can not be more than 255 characters'),
            'lastname.required' => __('Last name is a required field.'),
            'lastname.string' => __('Last name must be a string'),
            'lastname.max' => __('Last name can not be more than 255 characters'),
            'email.required' => __('Email address is a required field.'),
            'email.email' => __('Email field must be a valid email address.'),
            'email.max' => __('Email can not be more than 255 characters.')
        ];
    }
}
