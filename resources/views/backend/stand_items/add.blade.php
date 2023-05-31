@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 px-8 d-flex justify-content-between align-items-center flex-wrap">
        <div class="w-100">
            @include('global.notices')
        </div>
        <a href="{{ route('backend.stands.edit', ['exhibitionStand' => $exhibitionStand->id]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to stand') }}</a>
    </div>
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.stand_items.store', ['exhibitionStand' => $exhibitionStand->id]) }}"
                  method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Item name') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('On click behaviour') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('item_type') is-invalid @enderror"
                                    name="item_type">
                                @foreach ($itemTypes as $index => $itemType)
                                    <option
                                        value="{{ $index }}" {{ $index == old('item_type') ? 'selected' : '' }}>{{ $itemType }}</option>
                                @endforeach
                            </select>
                            @error('item_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div
                            class="mb-10 js-field-banner-type item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_YOUTUBE }} item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL }} item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE_FROM_EXTERNAL_URL }} item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_REDIRECT_TO_URL }}"
                            {!! !in_array(old('item_type'), [
                                \App\Models\ExhibitionStandItem::ITEM_TYPE_YOUTUBE,
                                \App\Models\ExhibitionStandItem::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL,
                                \App\Models\ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE_FROM_EXTERNAL_URL,
                                \App\Models\ExhibitionStandItem::ITEM_TYPE_REDIRECT_TO_URL
                                ]) ? 'style="display: none;"' : '' !!}>
                            <label class="form-label">
                                {{ __('Url') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text" class="form-control @error('url') is-invalid @enderror"
                                   name="url" value="{{ old('url') }}">
                            @error('url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div
                            class="mb-10 js-field-banner-type item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE }}"
                            {!! old('item_type') != \App\Models\ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE ? 'style="display: none;"' : '' !!}
                        >
                            <label class="form-label">
                                {{ __('Download file') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <image-upload
                                route="{{ route('backend.stand_items.file_upload', ['exhibitionStand' => $exhibitionStand->id]) }}"
                                field_filename="download_filename"
                                file_id="{{ old('download_file_id') }}"
                                file_url="{{ old('download_file_ul') }}"
                                field_name="download_file_id"
                                field_url_name="download_file_url"
                                filename="{{ old('download_filename') }}"
                                upload_type="file"
                            ></image-upload>
                            @error('download_file_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div
                            class="mb-10 js-field-banner-type item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_YOUTUBE }} item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_SIMPLE_BANNER }} item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE_FROM_EXTERNAL_URL }} item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_REDIRECT_TO_URL }} item-field-{{ \App\Models\ExhibitionStandItem::ITEM_TYPE_DOWNLOAD_FILE }}"
                            {!! old('item_type') == \App\Models\ExhibitionStandItem::ITEM_TYPE_BANNER_FROM_EXTERNAL_URL ? 'style="display: none;"' : '' !!}>
                            <label class="form-label">
                                {{ __('Item image') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <image-upload
                                route="{{ route('backend.stand_items.image_upload', ['exhibitionStand' => $exhibitionStand->id]) }}"
                                file_id="{{ old('banner_file_id') }}"
                                file_url="{{ old('banner_file_url') }}"
                                field_name="banner_file_id"
                                field_url_name="banner_file_url"
                            ></image-upload>
                            <small>{{ __('Banner size must be ') }}</small>
                            @error('banner_file_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">{{ __('Submit') }}</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">{{ __('Please wait...') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <!--end::Card body-->
    </div>
@stop
