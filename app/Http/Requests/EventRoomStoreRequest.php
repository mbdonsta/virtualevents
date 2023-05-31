<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRoomStoreRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'video_source_id' => 'required|integer|max:4',
            'embed_id' => 'required|string',
            'allow_all' => 'required|integer',
            'slido_url' => 'nullable|string',
            'media_file_id' => 'nullable|integer',
            'show_banner' => 'required|integer',
            'enabled' => 'nullable|integer|max:4',
            'room_participants' => 'nullable|array'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('Room name field is required.'),
            'name.string' => __('Room name must be a string.'),
            'name.max' => __('Room name can not be more than 255 symbols.'),
            'video_source_id.required' => __('Video source field is required.'),
            'video_source_id.integer' => __('Incorrect video source value.'),
            'embed_id.required' => __('Video ID is a required field.'),
            'allow_all.integer' => __('Incorrect room visibility value.'),
            'enabled.integer' => __('Incorrect room status value.'),
            'room_participants.array' => __('Incorrect room participants value.'),
            'slido_url.string' => __('Slido.com field must be a string.'),
            'media_file_id.integer' => __('Wrong image file value.'),
            'show_banner.integer' => __('This field value must be an integer.')
        ];
    }
}
