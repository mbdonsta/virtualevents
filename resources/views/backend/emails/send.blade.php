@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 mb-10 d-flex justify-content-between align-items-center">
        <h2 class="page-heading text-dark fw-bold fs-3 my-0">
            {{ __('Edit Invitation Email') }}
        </h2>
    </div>
    @include('global.notices')
    
@stop

