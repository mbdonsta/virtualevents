<?php

namespace App\Http\Requests;

use App\Models\Event;
use Illuminate\Foundation\Http\FormRequest;

class EventStoreRequest extends FormRequest
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
        $event = $this->route('event') ? $this->route('event') : null;
        $unique = $event ? 'unique:events,slug,' . $event->id : 'unique:events,slug';
        $titleOptions = [
            Event::TITLE_OPTION_SHOW_TITLE,
            Event::TITLE_OPTION_SHOW_LOGO_AS_TITLE,
            Event::TITLE_OPTION_HIDE_TITLE
        ];

        return [
            'title' => 'required|string|min:10|max:255',
            'title_option' => 'required|in:' . implode(',', $titleOptions),
            'slug' => 'required|string|min:10|max:255|regex:/^[a-z0-9\-]+$/|' . $unique,
            'subject' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'media_file_id' => 'nullable|integer',
            'begin_datetime' => 'required|date_format:Y-m-d H:i',
            'end_datetime' => 'required|date_format:Y-m-d H:i|after:begin_datetime',
            'location' => 'nullable|string|max:255',
            'language_id' => 'required|integer|max:4',
            'is_public' => 'required|integer|max:4',
            'enabled' => 'nullable|integer|max:4'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => __('Title field is required.'),
            'title.string' => __('Title must be a string.'),
            'title.min' => __('Title must be at least 10 symbols long.'),
            'title.max' => __('Title can not be more than 255 symbols.'),
            'title_option.required' => __('Title option is required.'),
            'title_option.in' => __('Incorrect title option is value.'),
            'slug.required' => __('Event url is required.'),
            'slug.string' => __('Event url must be a string.'),
            'slug.min' => __('Event url must be at least 10 symbols long.'),
            'slug.max' => __('Event url can not be more than 255 symbols.'),
            'slug.regex' => __('Url can contain only lowercase letters, numbers and symbol "-".'),
            'slug.unique' => __('This URL is already taken.'),
            'subject.string' => __('Subject must be a string.'),
            'subject.max' => __('Subject can not be more than 255 symbols.'),
            'description.string' => __('Description must be a string.'),
            'media_file_id.required' => __(':field is a required field.', ['field' => 'Event logo']),
            'media_file_id.integer' => __('Wrong image file value.'),
            'begin_datetime.required' => __('Begin date field is required.'),
            'begin_datetime.date_format' => __('Begin date must be a valid date.'),
            'end_datetime.required' => __('End date field is required.'),
            'end_datetime.date_format' => __('End date must be a valid date.'),
            'end_datetime.after' => __('End date must be later than the begin date.'),
            'location.string' => __('Location must be a string.'),
            'language_id.required' => __('Language field is required.'),
            'language_id.integer' => __('Incorrect language value.'),
            'is_public.required' => __('Type is required field.'),
            'is_public.integer' => __('Incorrect type value.'),
            'enabled.integer' => __('Incorrect status value.'),
        ];
    }
}
