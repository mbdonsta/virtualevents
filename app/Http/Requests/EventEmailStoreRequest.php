<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventEmailStoreRequest extends FormRequest
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
            'email_address' => 'required|email',
            'sender' => 'required|string',
            'reply_to' => 'required|email',
            'subject' => 'required|string',
            'text' => 'required|string',
            'email_styles' => 'array'
        ];
    }

    public function messages(): array
    {
        return [
            'email_address.required' => __(':field is a required field.', ['field' => 'Email address']),
            'email_address.email' => __(':field must be a valid email address.', ['field' => 'Email address']),
            'sender.required' => __(':field is a required field.', ['field' => 'Email from name']),
            'sender.string' => __(':field must be a string.', ['field' => 'Email from name']),
            'reply_to.required' => __(':field is a required field.', ['field' => 'Reply To email']),
            'reply_to.email' => __(':field must be a valid email address.', ['field' => 'Reply To']),
            'subject.required' => __(':field is a required field.', ['field' => 'Email subject']),
            'subject.string' => __(':field must be a string.', ['field' => 'Email subject']),
            'text.required' => __(':field is a required field.', ['field' => 'Email text']),
            'text.string' => __(':field must be a string.', ['field' => 'Email text']),
        ];
    }
}
