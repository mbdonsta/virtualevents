@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 px-8 mb-10 d-flex justify-content-between align-items-center flex-wrap">
        <div class="w-100">
            @include('global.notices')
        </div>
        <a href="{{ route('backend.stands.index', ['event' => $event]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to stands') }}</a>
    </div>

    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.stands.store', ['event' => $event->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Stand name') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Exhibition group') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('exhibition_group_id') is-invalid @enderror"
                                    name="exhibition_group_id">
                                @foreach ($exhibitionGroups as $exhibitionGroup)
                                    <option
                                        value="{{ $exhibitionGroup->id }}" {{ $exhibitionGroup->id == old('exhibition_group_id') ? 'selected' : '' }}>
                                        {{ $exhibitionGroup->getTitle() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exhibition_group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Stand logo') }}</label>
                            <image-upload
                                route="{{ route('backend.stands.logo_upload', ['event' => $event->id]) }}"
                                file_id="{{ old('media_file_id') }}"
                                file_url="{{ old('media_file_url') }}"
                                field_name="media_file_id"
                                field_url_name="media_file_url"
                                fit="1"
                            ></image-upload>
                            @error('media_file_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Stand featured image') }}</label>
                            <image-upload
                                route="{{ route('backend.stands.logo_upload', ['event' => $event->id]) }}"
                                file_id="{{ old('featured_image_id') }}"
                                file_url="{{ old('featured_image_url') }}"
                                field_name="featured_image_id"
                                field_url_name="featured_image_url"
                            ></image-upload>
                            @error('featured_image_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{--                    <div class="col-12">--}}
                    {{--                        <div class="mb-10">--}}
                    {{--                            <label class="form-label">--}}
                    {{--                                {{ __('Stand layout') }}--}}
                    {{--                                <small class="d-block">--}}
                    {{--                                    {{ __('Stand items will appear after you submit a stand.') }}--}}
                    {{--                                </small>--}}
                    {{--                            </label>--}}
                    {{--                            <!--begin::Radio group-->--}}
                    {{--                            <div data-kt-buttons="true" class="stand-layout-selection row">--}}
                    {{--                                @foreach($layouts as $value => $layout)--}}
                    {{--                                    <div class="col-md-3">--}}
                    {{--                                        @include('backend.stands.parts.layout_radio_' . $value, ['current' => '', 'value' => $value])--}}
                    {{--                                    </div>--}}
                    {{--                                @endforeach--}}
                    {{--                            </div>--}}
                    {{--                            <!--end::Radio group-->--}}
                    {{--                            @error('layout_style')--}}
                    {{--                            <div class="invalid-feedback d-block">{{ $message }}</div>--}}
                    {{--                            @enderror--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
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
