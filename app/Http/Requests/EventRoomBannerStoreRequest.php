<?php

namespace App\Http\Requests;

use App\Models\EventRoomBanner;
use Illuminate\Foundation\Http\FormRequest;

class EventRoomBannerStoreRequest extends FormRequest
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
            'banner_type' => 'required|integer',
            'banner_image_id' => 'required|integer',
            'download_file_id' => 'required_if:banner_type,' . EventRoomBanner::BANNER_TYPE_DOWNLOAD_FILE . '|integer|nullable',
            'banner_redirect_url' => 'max:256|required_if:banner_type,' . EventRoomBanner::BANNER_TYPE_REDIRECT_TO_URL,
            'youtube_url' => 'max:256|required_if:banner_type,' . EventRoomBanner::BANNER_TYPE_YOUTUBE_VIDEO,
        ];
    }

    public function messages(): array
    {
        return [
            'banner_type.required' => __(':field is a required field.', ['field' => 'Banner type']),
            'banner_image_id.required' => __(':field is a required field.', ['field' => 'Banner image']),
            'banner_image_id.integer' => __('This field value must be an integer.'),
            'download_file_id.required_if' => __(':field is a required field.', ['field' => 'Download file']),
            'banner_redirect_url.required_if' => __(':field is a required field.', ['field' => 'Redirect url']),
            'banner_redirect_url.max' => __(':field can not be more than 255 symbols.', ['field' => 'Redirect url']),
            'youtube_url.required_if' => __(':field is a required field.', ['field' => 'Redirect url']),
            'youtube_url.max' => __(':field can not be more than 255 symbols.', ['field' => 'Redirect url'])
        ];
    }
}
