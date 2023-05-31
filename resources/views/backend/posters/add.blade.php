@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 px-8 d-flex justify-content-between align-items-center flex-wrap">
        <div class="w-100">
            @include('global.notices')
        </div>
        <a href="{{ route('backend.posters.index', ['event' => $event]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to posters') }}</a>
    </div>

    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.posters.store', ['event' => $event->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Poster author') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text" class="form-control @error('author') is-invalid @enderror"
                                   name="author" value="{{ old('author') }}">
                            @error('author')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Poster description') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <textarea
                                type="text"
                                class="form-control @error('description') is-invalid @enderror"
                                name="description">
                                {{ old('description') }}
                            </textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Youtube video URL') }}
                            </label>
                            <input
                                type="text"
                                class="form-control @error('youtube_url') is-invalid @enderror"
                                name="youtube_url"
                                value="{{ old('youtube_url') }}">
                            @error('youtube_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Poster image') }}
                            </label>
                            <image-upload
                                route="{{ route('backend.posters.image_upload', ['event' => $event->id]) }}"
                                file_id="{{ old('poster_image_id') }}"
                                file_url="{{ old('poster_image_url') }}"
                                field_name="poster_image_id"
                                field_url_name="poster_image_url"
                            ></image-upload>
                            @error('poster_image_id')
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
