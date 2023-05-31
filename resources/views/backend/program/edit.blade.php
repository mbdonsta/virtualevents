@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 mb-10">
        <div class="px-8">
            @include('global.notices')
            <event-program-base
                please_wait_trans="{{ __('Please wait...') }}"
                submit_trans="{{ __('Submit') }}"
                submit_route="{{ route('backend.program.update', ['eventProgram' => $eventProgram->id]) }}"
                day_name="{{ $eventProgram->name }}"
                schedule="{{ $eventProgram->getContentJson() }}"
                image_upload_route="{{ route('backend.program.image_upload') }}"
            ></event-program-base>
        </div>
    </div>

@stop

