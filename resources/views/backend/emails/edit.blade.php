@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')

    <div class="pt-20 card card-flush mb-10">
        <div class="px-8">
            @include('global.notices')
        </div>
        <!--begin::Card body-->
        <div class="card-body py-0">
            <form action="{{ route('backend.emails.send.test', ['eventEmail' => $eventEmail->id]) }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Email address') }}</label>
                            <input type="text" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', auth()->user()->email) }}">
                            <small>{{ __('You will receive a test email with your profile data for this event.') }}</small>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">{{ __('Send test email') }}</span>
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
    <div class="px-8">
        <hr>
    </div>
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.emails.update', ['eventEmail' => $eventEmail->id]) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Event email address') }}</label>
                            <input type="text" class="form-control @error('email_address') is-invalid @enderror"
                                   name="email_address" value="{{ old('email_address', $eventEmail->email_address) }}">
                            @error('email_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Email from name') }}</label>
                            <input type="text" class="form-control @error('sender') is-invalid @enderror"
                                   name="sender" value="{{ old('sender', $eventEmail->sender) }}">
                            @error('sender')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Email subject') }}</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                   name="subject" value="{{ old('subject', $eventEmail->subject) }}">
                            @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Reply To email address') }}</label>
                            <input type="text" class="form-control @error('reply_to') is-invalid @enderror"
                                   name="reply_to" value="{{ old('reply_to', $eventEmail->reply_to) }}">
                            @error('reply_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Email background color') }}</label>
                            <input type="color" class="form-control @error('reply_to') is-invalid @enderror"
                                   name="email_styles[bg_color]"
                                   value="{{ old('email_styles', $eventEmail->getStyles())['bg_color'] }}">
                            @error('reply_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Email content background color') }}</label>
                            <input type="color" class="form-control @error('reply_to') is-invalid @enderror"
                                   name="email_styles[content_bg_color]"
                                   value="{{ old('email_styles', $eventEmail->getStyles())['content_bg_color'] }}">
                            @error('reply_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Email content text color') }}</label>
                            <input type="color" class="form-control @error('reply_to') is-invalid @enderror"
                                   name="email_styles[content_text_color]"
                                   value="{{ old('email_styles', $eventEmail->getStyles())['content_text_color'] }}">
                            @error('reply_to')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="alert bg-light mb-10">
                            <strong class="d-block mb-3">{{ __('Available place holders') }}</strong>
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-1">[Event_URL] - displays link to event.</p>
                                    <p class="mb-1">[Event_Subject] - displays event subject.</p>
                                    <p class="mb-1">[Event_Description] - displays event description.</p>
                                    <p class="mb-1">[Event_BeginTime] - displays event begin date and time.</p>
                                    <p class="mb-1">[Event_EndTime] - displays event begin date and time.</p>
                                    <p class="mb-1">[Event_Loc] - displays event location.</p>
                                </div>
                                <div class="col-md-6">
                                    <p class="mb-1">[Event_Lang] - displays event language.</p>
                                    <p class="mb-1">[Event_Email] - displays event email.</p>
                                    <p class="mb-1">[Event_User_Email] - displays event participant email address.</p>
                                    <p class="mb-1">[Event_User_Firstname] - displays event participant first name.</p>
                                    <p class="mb-1">[Event_User_Lastname] - displays event participant last name.</p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Email text') }}</label>
                            <textarea class="form-control @error('text') is-invalid @enderror"
                                      name="text">{{ old('text', $eventEmail->text) }}</textarea>
                            @error('text')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">{{ __('Submit') }}</span>
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

@section('scripts')
    <script src="{{ asset('/assets/js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: 'textarea',
            height: 300,
            plugins: [
                'link lists table code, paste'
            ],
            toolbar: 'undo redo | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist',
            paste_as_text: true
        });
    </script>
@stop

