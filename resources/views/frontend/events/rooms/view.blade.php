@extends('frontend.events.view')

@section('event_content')
    <div class="event-room-section">
        @if ($eventRoom->show_banner && $currentDateTime < $event->begin_datetime)
            @if ($eventRoom->mediaFile && $eventRoom->mediaFile->getUrl())
                <div class="event-banner">
                    <img src="{{ $eventRoom->mediaFile->getUrl() }}">
                </div>
            @endif
        @else
            @if ($eventRoom->embed_id)
                @if ($eventRoom->sourceYoutube())
                    <yt-live-player
                        room_id="{{ $eventRoom->id }}"
                        video_id="{{ $eventRoom->embed_id }}"
                    ></yt-live-player>
                @else

                @endif
            @endif
            @if ($eventRoom->slido_url)
                <div class="qa-block hidden">
                    <iframe src="{{ $eventRoom->slido_url }}" height="100%" width="100%" frameBorder="0"
                            style="min-height: 560px;" title="Slido"></iframe>
                </div>
            @endif
        @endif
        {{--        @if (!$banners->isEmpty())--}}
        {{--            @include('frontend.events.rooms.banners', ['banners' => $banners])--}}
        {{--        @endif--}}
    </div>
    <div class="qa-section py-5">
        @if ($eventRoom->slido_url)
            <button class="qa-toggle btn btn-primary">
                <svg viewBox="0 0 24 24" fill="#fff" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M16.1266 22.1995C16.7081 22.5979 17.4463 23.0228 18.3121 23.3511C19.9903 23.9874 21.244 24.0245 21.8236 23.9917C23.1167 23.9184 23.2907 23.0987 22.5972 22.0816C21.8054 20.9202 21.0425 19.6077 21.1179 18.1551C22.306 16.3983 23 14.2788 23 12C23 5.92487 18.0751 1 12 1C5.92487 1 1 5.92487 1 12C1 18.0751 5.92487 23 12 23C13.4578 23 14.8513 22.7159 16.1266 22.1995ZM12 3C7.02944 3 3 7.02944 3 12C3 16.9706 7.02944 21 12 21C13.3697 21 14.6654 20.6947 15.825 20.1494C16.1635 19.9902 16.5626 20.0332 16.8594 20.261C17.3824 20.6624 18.1239 21.1407 19.0212 21.481C19.4111 21.6288 19.7674 21.7356 20.0856 21.8123C19.7532 21.2051 19.4167 20.4818 19.2616 19.8011C19.1018 19.0998 18.8622 17.8782 19.328 17.2262C20.3808 15.7531 21 13.9503 21 12C21 7.02944 16.9706 3 12 3ZM13.25 16.75C13.25 17.4404 12.6904 18 12 18C11.3096 18 10.75 17.4404 10.75 16.75C10.75 16.0596 11.3096 15.5 12 15.5C12.6904 15.5 13.25 16.0596 13.25 16.75ZM10.1353 8.96435C10.3999 8.45957 11.0831 8 12 8C13.283 8 14 8.83454 14 9.5C14 10.1655 13.283 11 12 11C11.4477 11 11 11.4477 11 12V13C11 13.5523 11.4477 14 12 14C12.5523 14 13 13.5523 13 13V12.8866C14.6316 12.5135 16 11.2471 16 9.5C16 7.40403 14.0307 6 12 6C10.4566 6 9.0252 6.77452 8.36398 8.03565C8.10753 8.52478 8.29615 9.1292 8.78528 9.38565C9.27442 9.64211 9.87883 9.45348 10.1353 8.96435Z"
                          fill="#000000"/>
                </svg>
                {{ __('Questions/Answers') }}
            </button>
        @endif
    </div>
@stop
