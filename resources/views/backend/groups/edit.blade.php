@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 px-8 d-flex justify-content-end align-items-center flex-wrap">
        <div class="w-100">
            @include('global.notices')
        </div>
        <a href="{{ route('backend.groups.index', ['event' => $exhibitionGroup->event->id]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to groups') }}</a>
    </div>

    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.groups.update', ['exhibitionGroup' => $exhibitionGroup->id]) }}"
                  method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Group title') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror"
                                   name="title" value="{{ old('title', $exhibitionGroup->title) }}">
                            @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Group layout') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('columns') is-invalid @enderror"
                                    name="columns">
                                @foreach (range(1, 2) as $column)
                                    <option
                                        value="{{ $column }}" {{ $column == old('columns', $exhibitionGroup->columns) ? 'selected' : '' }}>
                                        {{ $column > 1 ? __(':number columns', ['number' => $column]) : __(':number column', ['number' => $column]) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('video_type_id')
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
