@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')

    <div class="pt-20 px-8">
        @include('global.notices')
        @can('edit', $event)
            <div class="d-flex justify-content-between">
                <a href="{{ route('backend.events.index') }}"
                   class="btn btn-primary btn-sm">{{ __('Back to events') }}</a>
            </div>
            <hr>
        @endcan
    </div>


    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.events.update', ['event' => $event->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <label>{{ __('Event Url') }}</label>
                        <edit-slug url="{{ url()->to('/') }}"
                                   is_error="{{ $errors->has('slug') ? 1 : '' }}"
                                   slug="{{ old('slug', $event->slug) }}"></edit-slug>
                        <div>
                            <small>{{ __('Url can only contain lowercase letters, numbers and symbol "-"') }}</small>
                        </div>
                        @error('slug')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <div class="">
                            <label class="form-label">{{ __('Event logo') }}</label>
                            <image-upload
                                route="{{ route('backend.events.logo_upload') }}"
                                file_id="{{ old('media_file_id', $event->media_file_id) }}"
                                file_url="{{ $event->mediaFile ? old('media_file_url', $event->mediaFile->getUrl()) : old('media_file_url') }}"
                                field_name="media_file_id"
                                field_url_name="media_file_url"
                                fit="1"
                            ></image-upload>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Event title') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <textarea class="form-control @error('title') is-invalid @enderror" rows="2"
                                      name="title">{{ old('title', $event->title) }}</textarea>
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Title options') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('title_option') is-invalid @enderror"
                                    name="title_option">
                                @foreach ($titleOptions as $option)
                                    <option
                                        value="{{ $option['id'] }}" {{ $option['id'] == old('title_option', $event->title_option) ? 'selected' : '' }}>
                                        {{ $option['name'] }}
                                    </option>
                                @endforeach
                            </select>
                            @error('title_option')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Begin date and time') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text"
                                   class="form-control @error('begin_datetime') is-invalid @enderror js-datepick"
                                   name="begin_datetime"
                                   value="{{ old('begin_datetime', $event->begin_datetime) }}">
                            <small
                                class="text-muted">{{ __('Supported date format is: YYYY-MM-DD HH:mm') }}</small>
                            @error('begin_datetime')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('End date and time') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text"
                                   class="form-control @error('end_datetime') is-invalid @enderror js-datepick"
                                   name="end_datetime"
                                   value="{{ old('end_datetime', $event->end_datetime) }}">
                            <small
                                class="text-muted">{{ __('Supported date format is: YYYY-MM-DD HH:mm') }}</small>
                            @error('end_datetime')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Event location') }}</label>
                            <input type="text" class="form-control @error('location') is-invalid @enderror"
                                   name="location"
                                   value="{{ old('location', $event->location) }}">
                            @error('location')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Event language') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('language_id') is-invalid @enderror"
                                    name="language_id">
                                @foreach ($languages as $language)
                                    <option
                                        value="{{ $language->id }}" {{ $language->id == old('language_id', $event->language_id) ? 'selected' : '' }}>{{ $language->name }}</option>
                                @endforeach
                            </select>
                            @error('language_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Event type') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('is_public') is-invalid @enderror"
                                    name="is_public">
                                <option
                                    value="0" {{ 0 == old('is_public', $event->is_public) ? 'selected' : '' }}>{{ __('Private') }}</option>
                                <option
                                    value="1" {{ 1 == old('is_public', $event->is_public) ? 'selected' : '' }}>{{ __('Public') }}</option>
                            </select>
                            @error('is_public')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label mb-4">{{ __('Event status') }}</label>
                            <label
                                class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" name="enabled" type="checkbox"
                                       value="1" {{ old('enabled', $event->enabled) && 1 == old('enabled', $event->enabled) ? 'checked' : '' }}>
                                <span class="form-check-label fw-semibold text-muted">
                                        {{ __('Is Enabled') }}
                                    </span>
                            </label>
                            <div class="form-control @error('enabled') is-invalid @enderror d-none"></div>
                            @error('enabled')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">{{ __('Update') }}</span>
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
