@extends('backend.layouts.app')

@section('content')
    @include('backend.components.page_title', ['title' => $pageTitle])
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-md-3">
                @include('backend.events.parts.sidebar')
            </div>
            <div class="col-md-9">
                @yield('event_wrapper_content')
            </div>
        </div>
    </div>
@stop
