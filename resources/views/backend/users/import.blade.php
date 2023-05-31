@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 px-8 d-flex justify-content-between align-items-center flex-wrap">
        <a href="{{ route('backend.users.index', ['event' => $event]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to event users') }}</a>
        <div class="alert alert-primary d-flex align-items-center p-5 mt-5 mb-5 w-100">
            <!--begin::Svg Icon | path: icons/duotune/general/gen048.svg-->
            <span class="svg-icon svg-icon-2hx svg-icon-primary me-4">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.3"
                      d="M12 22C13.6569 22 15 20.6569 15 19C15 17.3431 13.6569 16 12 16C10.3431 16 9 17.3431 9 19C9 20.6569 10.3431 22 12 22Z"
                      fill="currentColor"/>
                <path
                    d="M19 15V18C19 18.6 18.6 19 18 19H6C5.4 19 5 18.6 5 18V15C6.1 15 7 14.1 7 13V10C7 7.6 8.7 5.6 11 5.1V3C11 2.4 11.4 2 12 2C12.6 2 13 2.4 13 3V5.1C15.3 5.6 17 7.6 17 10V13C17 14.1 17.9 15 19 15ZM11 10C11 9.4 11.4 9 12 9C12.6 9 13 8.6 13 8C13 7.4 12.6 7 12 7C10.3 7 9 8.3 9 10C9 10.6 9.4 11 10 11C10.6 11 11 10.6 11 10Z"
                    fill="currentColor"/>
            </svg>
        </span>
            <!--end::Svg Icon-->
            <div class="d-flex flex-column">
                <h4 class="mb-1 text-primary">{{ __('Note') }}</h4>
                <p>{!! __('Your event plan can have maximum of <strong>:num</strong> participants. Your currently have <strong>:count</strong> already.', ['num' => $event->plan->maxParticipants(), 'count' => count($event->eventUsers)]) !!}</p>
                <span>{{ __('Import file must be in CSV format, columns must be separated with a comma and must include 3 columns: First name, Last name, Email address.') }}</span>
                <div class="pt-5">
                    <a href="{{ asset('assets/files/event-users-import.csv') }}" class="btn btn-primary btn-sm"
                       download>
                        {{ __('Download File Example') }}
                    </a>
                </div>
            </div>
        </div>
        @include('global.notices')
    </div>
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <event-users-import
                label_trans="{{ __('Import file. Must be in CSV format.') }}"
                button_trans="{{ __('Start Import') }}"
                loading_trans="{{ __('Importing...') }}"
                auth_trans="{{ __('You are not authorized to do this action.') }}"
                file_check_route="{{ route('backend.users_import.check_file', ['event' => $event->id]) }}"
                import_users_route="{{ route('backend.users_import.import', ['event' => $event->id]) }}"
            ></event-users-import>
        </div>
        <!--end::Card body-->
    </div>
@stop
