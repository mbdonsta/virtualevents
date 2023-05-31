<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRegisterRequest extends FormRequest
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
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()],
            'terms' => 'required'
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
            'email.required' => __('Email address is required field.'),
            'email.email' => __('Email field must be a valid email address.'),
            'email.unique' => __('This email address is already in use.'),
            'email.max' => __('Email can not be more than 255 characters.'),
            'password.required' => __('Password field is required.'),
            'password.confirmed' => __('Password confirmation does not match.'),
            'password.min' => __('Password must be at least 8 characters long.'),
            'terms.required' => __('You must agree with out terms and conditions.')
        ];
    }
}
