@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 px-8 d-flex justify-content-end align-items-center flex-wrap">
        <div class="flex-grow-1  w-100">
            @include('global.notices')
            @if ($errors->any())
                @include('global.alerts.alert-danger', ['message' => __('There are validation error in the form.')])
            @endif
        </div>
        <a href="{{ route('backend.rooms.index', ['event' => $eventRoom->event_id]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to rooms') }}</a>
    </div>
    {{--    <div class="card mb-10">--}}
    {{--        <div class="card-header align-items-center">--}}
    {{--            <h3 class="card-title">{{ __('Room ad banners') }}</h3>--}}
    {{--            <a href="{{ route('backend.room_banners.add', ['eventRoom' => $eventRoom->id]) }}"--}}
    {{--               class="btn btn-sm btn-primary">--}}
    {{--                <span class="d-inline-block">{{ __('Create') }}</span>--}}
    {{--            </a>--}}
    {{--        </div>--}}
    {{--        <div class="card-body">--}}
    {{--            @if (!$eventRoom->banners->isEmpty())--}}
    {{--                <event-room-banners--}}
    {{--                    banners_json="{{ json_encode($eventRoom->banners()->oldest('menu_order')->get()) }}"--}}
    {{--                    reorder_route="{{ route('backend.room_banners.reorder', ['eventRoom' => $eventRoom->id]) }}"></event-room-banners>--}}
    {{--            @endif--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.rooms.update', ['eventRoom' => $eventRoom->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Room name') }}</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name', $eventRoom->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Video source') }}</label>
                            <select class="form-select @error('video_source_id') is-invalid @enderror"
                                    name="video_source_id">
                                @foreach ($videoSources as $source)
                                    <option
                                        value="{{ $source->id }}" {{ $source->id == old('video_source_id', $eventRoom->video_source_id) ? 'selected' : '' }}>{{ $source->name }}</option>
                                @endforeach
                            </select>
                            @error('video_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Video ID') }}</label>
                            <input type="text" class="form-control @error('embed_id') is-invalid @enderror"
                                   name="embed_id" value="{{ old('embed_id', $eventRoom->embed_id) }}">
                            <small
                                class="d-block">{!! __('Youtube video id is bolded in example: https://www.youtube.com/watch?v=<strong>WislvTLHayd</strong>') !!}</small>
                            <small
                                class="d-block">{!! __('Vimeo video id is bolded in example: https://vimeo.com/<strong>009999999</strong>') !!}</small>
                            @error('embed_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Room banner for video') }}</label>
                            <image-upload
                                route="{{ route('backend.rooms.banner_upload', ['event' => $event->id]) }}"
                                file_id="{{ old('media_file_id', $eventRoom->media_file_id) }}"
                                file_url="{{ $eventRoom->mediaFile ? old('media_file_url', $eventRoom->mediaFile->getUrl()) : old('media_file_url') }}"
                                field_name="media_file_id"
                                field_url_name="media_file_url"
                            ></image-upload>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Show room banner instead of room video') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('show_banner') is-invalid @enderror" name="show_banner">
                                <option
                                    value="0" {{ 0 == old('show_banner', $eventRoom->show_banner) ? 'selected' : '' }}>{{ __('No') }}</option>
                                <option
                                    value="1" {{ 1 == old('show_banner', $eventRoom->show_banner) ? 'selected' : '' }}>{{ __('Yes') }}</option>
                            </select>
                            @error('allow_all')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Slido.com embed url') }}</label>
                            <textarea class="form-control @error('slido_url') is-invalid @enderror"
                                      rows="2" name="slido_url">{{ old('slido_url', $eventRoom->slido_url) }}</textarea>
                            @error('slido_url')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Room visibility') }}</label>
                            <select class="form-select @error('allow_all') is-invalid @enderror" name="allow_all">
                                <option
                                    value="1" {{ 1 == old('allow_all', $eventRoom->allow_all) ? 'selected' : '' }}>{{ __('Visible to all event participants') }}</option>
                                <option
                                    value="0" {{ 0 == old('allow_all', $eventRoom->allow_all) ? 'selected' : '' }}>{{ __('Visible to specific event participants') }}</option>
                            </select>
                            @error('allow_all')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label mb-4">{{ __('Room status') }}</label>
                            <label
                                class="form-check form-switch form-check-custom form-check-solid">
                                <input class="form-check-input" name="enabled" type="checkbox"
                                       value="1" {{ old('enabled', $eventRoom->enabled) && 1 == old('enabled', $eventRoom->enabled) ? 'checked' : '' }}>
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
                    <div class="js-participants-box col-md-12">
                        <div class="mb-10 select2-theme">
                            <label class="form-label mb-4">{{ __('Room participants') }}</label>
                            <select class="form-select select2" name="room_participants[]"
                                    data-route="{{ route('backend.users.get_list', ['event' => $eventRoom->event_id]) }}"
                                    data-placeholder="{{ __('Type user first name, last name or email') }}" multiple>
                                @foreach($eventRoom->eventRoomUsers as $eventRoomUser)
                                    @if (!$eventRoomUser->user)
                                        @continue
                                    @endif
                                    <option
                                        value="{{ $eventRoomUser->user_id }}" {{ is_array(old('room_participants', $eventRoom->getParticipantIds())) && in_array($eventRoomUser->user_id, old('room_participants', $eventRoom->getParticipantIds())) ? 'selected' : '' }}>
                                        {{ $eventRoomUser->user->getFullName() }}
                                        ({{ $eventRoomUser->user->getEmail() }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-control @error('room_participants') is-invalid @enderror d-none"></div>
                            @error('room_participants')
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
