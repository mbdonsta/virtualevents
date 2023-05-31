@extends('backend.layouts.app')

@section('title')
    {{ __('Sign In') }}
@stop

@section('content')
    @include('backend.components.page_title', ['title' => __('Login For Organizers')])
    <!--begin::Authentication - Sign-up -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="text-center mb-11">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder mb-3">{{ __('Login') }}</h1>
                <!--end::Title-->
            </div>
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div id="loginFormHolder" class="w-lg-500px p-15 rounded">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="loginForm" method="POST"
                          action="{{ route('auth.post_login') }}">
                        @csrf
                        <!--begin::Heading-->

                        <!--begin::Heading-->
                        @error('invalid-login')
                        <div class="alert-danger alert">{{ $message }}</div>
                        @enderror
                        @if(session()->has('error'))
                            <div class="alert-danger alert">{{ session()->get('error') }}</div>
                        @endif
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="{{ __('Email') }}" name="email" autocomplete="off"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}"/>
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                            <!--end::Email-->
                        </div>
                        <!--begin::Input group-->
                        <div class="fv-row mb-8">
                            <!--begin::Wrapper-->
                            <div class="mb-1">
                                <!--begin::Input wrapper-->
                                <div class="position-relative mb-3">
                                    <input class="form-control @error('password') is-invalid @enderror"
                                           type="password" placeholder="{{ __('Password') }}"
                                           name="password" autocomplete="off"/>
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <span
                                        class="js-pass-field-toggle btn btn-sm btn-secondary position-absolute top-0 end-0 mt-2 py-2 me-2 px-1">
												<span class="show">{{ __('Show') }}</span>
                                                <span class="hide d-none">{{ __('Hide') }}</span>
											</span>
                                </div>
                            </div>
                            <!--end::Wrapper-->
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Submit button-->
                        <div class="d-grid">
                            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">{{ __('Login') }}</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">{{ __('Please wait...') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->
        </div>
        <!--end::Body-->
    </div>
    <!--end::Authentication - Sign-up-->
@stop
