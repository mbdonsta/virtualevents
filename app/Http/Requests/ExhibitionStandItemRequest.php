<?php

namespace App\Http\Requests;

use App\Models\ExhibitionStandItem;
use Illuminate\Foundation\Http\FormRequest;

class ExhibitionStandItemRequest extends FormRequest
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
            'name' => 'required|max:255',
            'item_type' => 'required|in:' . implode(',', ExhibitionStandItem::getItemTypeValues()),
            'banner_file_id' => 'required_unless:item_type,' . ExhibitionStandItem::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL,
            'download_file_id' => 'required_if:item_type,' . ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE,
            'url' => 'required_if:item_type,' . ExhibitionStandItem::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL . '|max:255'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __(':field is a required field.', ['field' => 'Item name']),
            'name.max' => __(':field can not be more than 255 symbols.', ['field' => 'Item name']),
            'item_type.required' => __(':field is a required field.', ['field' => 'On click behaviour']),
            'item_type.in' => __('This field value is invalid.'),
            'banner_file_id.required_unless' => __(':field is a required field.', ['field' => 'Item image']),
            'download_file_id.required_if' => __(':field is a required field.', ['field' => 'Download file']),
            'url.required_if' => __(':field is a required field.', ['field' => 'Url']),
            'url.max' => __(':field can not be more than 255 symbols.', ['field' => 'Url']),
        ];
    }
}
