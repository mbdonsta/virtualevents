@extends('auth.layouts.auth')

@section('title')
    Register
@stop

@section('content')
    <div class="d-flex flex-column flex-root" id="kt_app_root">
        <!--begin::Authentication - Signup Welcome Message -->
        <div class="d-flex flex-column flex-center flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center text-center p-10">
                <!--begin::Wrapper-->
                <div class="card card-flush w-md-650px py-5">
                    <div class="card-body py-15 py-lg-20">
                        <!--begin::Logo-->
                        <div class="mb-7">
                            <a href="{{ route('get_login') }}" class="">
                                <img alt="Logo" src="/assets/images/logo.jpg" class="h-100px"/>
                            </a>
                        </div>
                        <!--end::Logo-->
                        <!--begin::Title-->
                        <h1 class="fw-bolder text-gray-900 mb-5">{{ __('Welcome to Events platform') }}</h1>
                        <!--end::Title-->
                        <!--begin::Text-->
                        <div class="fw-semibold fs-6 text-gray-500 mb-7">
                            {{ __('Your registration was successful.') }}<br>
                            {{ __('You can now log in.') }}
                        </div>
                        <!--end::Text-->
                        <!--begin::Link-->
                        <div class="mb-0">
                            <a href="{{ route('get_login') }}"
                               class="btn btn-sm btn-primary">{{ __('Sign In') }}</a>
                        </div>
                        <!--end::Link-->
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Authentication - Signup Welcome Message-->
    </div>
@stop
