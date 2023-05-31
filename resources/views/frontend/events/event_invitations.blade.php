@extends('frontend.layouts.app')

@section('content')
    <div class="container-xxl">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="p-lg-20">
                    <h1 class="mb-20">{{ __('Invitations') }}</h1>
                    <div class="events-list">
                        @forelse ($events as $event)
                            <div
                                class="event-item d-flex flex-stack text-start p-6 mb-5 bg-white">
                                <!--end::Description-->
                                <div class="d-flex align-items-center me-2">
                                    <!--begin::Info-->
                                    <div class="flex-grow-1">
                                        <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap">
                                            {{ $event->getTitle() }}
                                            @if ($event->isLive())
                                                <span class="badge badge-light-success ms-2 fs-7">Live now</span>
                                            @endif
                                        </h2>
                                        @if ($event->subject)
                                            <div class="fw-semibold opacity-50">{{ $event->subject }}</div>
                                        @endif
                                        <div class="fw-semibold opacity-50">{!! $event->getTimeAndLocation() !!}</div>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Description-->
                                <!--begin::Price-->
                                <div class="ms-5">
                                    <a href="{{ $event->getUrl() }}" class="btn btn-primary">Enter</a>
                                </div>
                                <!--end::Price-->
                            </div>
                        @empty
                            <div
                                class="event-item d-flex flex-stack text-start p-6 mb-5 bg-white">
                                <!--end::Description-->
                                <div class="d-flex align-items-center me-2">
                                    <!--begin::Info-->
                                    <div class="flex-grow-1">
                                        <h2 class="d-flex align-items-center fs-3 fw-bold flex-wrap">
                                            {{ __('You are not invited to any events.') }}
                                        </h2>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::Description-->
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
