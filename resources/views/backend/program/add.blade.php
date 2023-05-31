@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-10 px-8 mb-10">
        <div class="mb-10">
            @include('global.notices')
        </div>
        <event-program-base
            please_wait_trans="{{ __('Please wait...') }}"
            submit_trans="{{ __('Submit') }}"
            submit_route="{{ route('backend.program.store', ['event' => $event->id]) }}"
            schedule=""
            image_upload_route="{{ route('backend.program.image_upload') }}"
        ></event-program-base>
    </div>

@stop

