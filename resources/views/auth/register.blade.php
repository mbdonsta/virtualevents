@extends('auth.layouts.auth')

@section('title')
    Register
@stop

@section('content')
    <!--begin::Authentication - Sign-up -->
    <div class="d-flex flex-column flex-lg-row flex-column-fluid">
        <!--begin::Body-->
        <div class="d-flex flex-column flex-lg-row-fluid w-lg-50 p-10 order-2 order-lg-1">
            <!--begin::Form-->
            <div class="d-flex flex-center flex-column flex-lg-row-fluid">
                <!--begin::Wrapper-->
                <div class="w-lg-500px p-10">
                    <!--begin::Form-->
                    <form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" method="POST"
                          action="{{ route('auth.post_register') }}">
                        @csrf
                        <!--begin::Heading-->
                        <div class="text-center mb-11">
                            <!--begin::Title-->
                            <h1 class="text-dark fw-bolder mb-3">{{ __('Sign Up') }}</h1>
                            <!--end::Title-->
                        </div>
                        <!--begin::Heading-->
                        <!--begin::Input group=-->
                        <div class="fv-row row mb-8">
                            <div class="col-md-6">
                                <input type="text" placeholder="{{ __('First name') }}" name="firstname"
                                       autocomplete="off"
                                       class="form-control bg-transparent @error('firstname') is-invalid @enderror"
                                       value="{{ old('firstname') }}"/>
                                @error('firstname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <input type="text" placeholder="{{ __('Last name') }}" name="lastname"
                                       autocomplete="off"
                                       class="form-control bg-transparent @error('lastname') is-invalid @enderror"
                                       value="{{ old('lastname') }}"/>
                                @error('lastname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>

                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group=-->
                        <div class="fv-row mb-8">
                            <!--begin::Email-->
                            <input type="text" placeholder="{{ __('Email') }}" name="email" autocomplete="off"
                                   class="form-control bg-transparent @error('email') is-invalid @enderror"
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
                                    <input class="form-control bg-transparent @error('password') is-invalid @enderror"
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
                            <!--begin::Hint-->
                            <div class="text-muted">
                                {{ __('Use :length or more characters with a mix of letters, numbers & symbols.', ['length' => 8]) }}
                            </div>
                            <!--end::Hint-->
                        </div>
                        <!--end::Input group=-->
                        <!--end::Input group=-->
                        <div class="position-relative fv-row mb-8">
                            <!--begin::Repeat Password-->
                            <input placeholder="{{ __('Repeat Password') }}" name="password_confirmation"
                                   type="password"
                                   autocomplete="off" class="form-control bg-transparent"/>
                            <span
                                class="js-pass-field-toggle btn btn-sm btn-secondary position-absolute top-0 end-0 mt-2 py-2 me-2 px-1">
												<span class="show">{{ __('Show') }}</span>
                                                <span class="hide d-none">{{ __('Hide') }}</span>
											</span>
                            <!--end::Repeat Password-->
                        </div>
                        <!--end::Input group=-->
                        <!--begin::Accept-->
                        <div class="fv-row mb-8">
                            <label class="form-check form-check-inline">
                                <input class="form-check-input" type="checkbox" name="terms"
                                       value="1" {{ old('terms') ? 'checked' : '' }}/>
                                <span class="form-check-label fw-semibold text-gray-700 fs-base ms-1">
                                    {!! __('I Accept the <a href=":link" class=":classes">Terms</a>', ['link' => '#', 'classes' => 'link-primary']) !!}
                                </span>
                            </label>
                            <div class="d-none form-control @error('terms') is-invalid @enderror"></div>
                            @error('terms')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <!--end::Accept-->
                        <!--begin::Submit button-->
                        <div class="d-grid mb-10">
                            <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                                <!--begin::Indicator label-->
                                <span class="indicator-label">{{ __('Sign Up') }}</span>
                                <!--end::Indicator label-->
                                <!--begin::Indicator progress-->
                                <span class="indicator-progress">{{ __('Please wait...') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                                <!--end::Indicator progress-->
                            </button>
                        </div>
                        <!--end::Submit button-->
                        <!--begin::Sign up-->
                        <div class="text-gray-500 text-center fw-semibold fs-6">
                            {{ __('Already have an Account?') }}
                            <a href="{{ route('get_login') }}"
                               class="link-primary fw-semibold">{{ __('Sign in') }}</a>
                        </div>
                        <!--end::Sign up-->
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Form-->
        </div>
        <!--end::Body-->
        <!--begin::Aside-->
        <div class="d-flex flex-lg-row-fluid w-lg-50 bgi-size-cover bgi-position-center order-1 order-lg-2"
             style="background-image: url({{ asset('assets/images/auth-bg.png') }})">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-center py-7 py-lg-15 px-5 px-md-15 w-100">
                <!--begin::Logo-->
                <a href="{{ route('get_login') }}" class="mb-0 mb-lg-12">
                    <img alt="Logo" src="{{ asset('assets/images/logo.jpg') }}" class="h-60px h-lg-75px"/>
                </a>
                <!--end::Logo-->
                <!--begin::Image-->
                <img class="d-none d-lg-block mx-auto w-275px w-md-50 w-xl-500px mb-10 mb-lg-20"
                     src="{{ asset('assets/images/auth-screens.png') }}" alt=""/>
                <!--end::Image-->
                <!--begin::Title-->
                <h1 class="d-none d-lg-block text-white fs-2qx fw-bolder text-center mb-7">Fast, Efficient and
                    Productive</h1>
                <!--end::Title-->
                <!--begin::Text-->
                <div class="d-none d-lg-block text-white fs-base text-center">In this kind of post,
                    <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the blogger</a>introduces a person
                    they’ve interviewed
                    <br/>and provides some background information about
                    <a href="#" class="opacity-75-hover text-warning fw-bold me-1">the interviewee</a>and their
                    <br/>work following this is a transcript of the interview.
                </div>
                <!--end::Text-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Aside-->
    </div>
    <!--end::Authentication - Sign-up-->
@stop
