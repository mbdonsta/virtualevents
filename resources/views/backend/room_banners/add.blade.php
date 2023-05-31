@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 mb-10 d-flex justify-content-between align-items-center">
        <h2 class="page-heading text-dark fw-bold fs-3 my-0">
            {{ __('Create Room ad banner') }}
        </h2>
        <a href="{{ route('backend.rooms.edit', ['eventRoom' => $eventRoom->id]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to room') }}</a>
    </div>
    @include('global.notices')

    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.room_banners.store', ['eventRoom' => $eventRoom->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Banner type') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('video_source_id') is-invalid @enderror"
                                    name="banner_type">
                                @foreach ($bannerTypes as $index => $bannerType)
                                    <option
                                        value="{{ $index }}" {{ $index == old('banner_type') ? 'selected' : '' }}>{{ $bannerType }}</option>
                                @endforeach
                            </select>
                            @error('banner_type')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div
                            class="mb-10 js-field-banner-type"
                            {!! old('banner_type') != \App\Models\EventRoomBanner::BANNER_TYPE_DOWNLOAD_FILE ? 'style="display: none;"' : '' !!}
                            data-field-type="{{ \App\Models\EventRoomBanner::BANNER_TYPE_DOWNLOAD_FILE }}">
                            <label class="form-label">{{ __('Download file') }}</label>
                            <image-upload
                                route="{{ route('backend.room_banners.file_upload', ['eventRoom' => $eventRoom->id]) }}"
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
                        <div
                            class="mb-10 js-field-banner-type"
                            {!! old('banner_type') != \App\Models\EventRoomBanner::BANNER_TYPE_REDIRECT_TO_URL ? 'style="display: none;"' : '' !!}
                            data-field-type="{{ \App\Models\EventRoomBanner::BANNER_TYPE_REDIRECT_TO_URL }}">
                            <label class="form-label">{{ __('Redirect to url') }}</label>
                            <input type="text" class="form-control @error('banner_redirect_url') is-invalid @enderror"
                                   name="banner_redirect_url" value="{{ old('banner_redirect_url') }}">
                            @error('banner_redirect_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div
                            class="mb-10 js-field-banner-type"
                            {!! old('banner_type') != \App\Models\EventRoomBanner::BANNER_TYPE_YOUTUBE_VIDEO ? 'style="display: none;"' : '' !!}
                            data-field-type="{{ \App\Models\EventRoomBanner::BANNER_TYPE_YOUTUBE_VIDEO }}">
                            <label class="form-label">{{ __('Youtube video url url') }}</label>
                            <input type="text" class="form-control @error('youtube_url') is-invalid @enderror"
                                   name="youtube_url" value="{{ old('youtube_url') }}">
                            @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Banner image') }}</label>
                            <image-upload
                                route="{{ route('backend.room_banners.banner_upload', ['eventRoom' => $eventRoom->id]) }}"
                                file_id="{{ old('banner_image_id') }}"
                                file_url="{{ old('banner_image_url') }}"
                                field_name="banner_image_id"
                                field_url_name="banner_image_url"
                            ></image-upload>
                            @error('banner_image_id')
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
