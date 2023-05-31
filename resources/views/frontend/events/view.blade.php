@extends('frontend.layouts.app')

@section('styles')
    <style>
        @if (!empty($event->designSettings()))
            @foreach ($event->designSettings() as $index => $value)
                {!! $index === 'bg_color' && $value ? '#eventLanding { background-color: ' . $value . ' }' : '' !!}
                {!! $index === 'title_fontsize' && $value ? '#eventLanding .event-title h1 { font-size: ' . $value . 'px; }' : '' !!}
                {!! $index === 'title_logo_size' && $value ? '#eventLanding .event-title img { height: ' . $value . 'px; }' : '' !!}
                {!! $index === 'title_margin_bottom' && $value ? '#eventLanding .event-title { margin-bottom: ' . $value . 'px; }' : '' !!}
                {!! $index === 'title_color' && $value ? '#eventLanding .event-title h1 { color: ' . $value . ' }' : '' !!}
                {!! (int) $event->designSettings()['title_effect'] === 1 && $index === 'title_shadow_color' && $value ? '#eventLanding .event-title h1 { text-shadow: 0 0 4px ' . $value . ' }' : '' !!}
                {!! $index === 'show_days' && $value == 0 ? '#eventLanding #eventSchedule .day-filter { display: none; }' : '' !!}
                {!! $index === 'show_rooms' && $value == 0 ? '#eventLanding #eventSchedule .rooms { display: none; }' : '' !!}
                {!! $index === 'day_button_bg' && $value ? '#eventLanding #eventSchedule .day-filter a { background: ' . $value . '; border-color: ' . $value . ' }' : '' !!}
                {!! $index === 'day_button_text' && $value ? '#eventLanding #eventSchedule .day-filter a { color: ' . $value . '; }' : '' !!}
                {!! $index === 'room_button_bg' && $value ? '#eventLanding #eventSchedule .rooms a { background: ' . $value . '; border-color: ' . $value . ' }' : '' !!}
                {!! $index === 'room_button_text' && $value ? '#eventLanding #eventSchedule .rooms a { color: ' . $value . '; }' : '' !!}
                {!! $index === 'time_col_bg_even' && $value ? '#eventSchedule .schedule-content-item .left-side.even { background: ' . $value . '; }' : '' !!}
                {!! $index === 'time_col_text_even' && $value ? '#eventSchedule .schedule-content-item .left-side.even { color: ' . $value . '; }' : '' !!}
                {!! $index === 'time_col_bg_odd' && $value ? '#eventSchedule .schedule-content-item .left-side.odd { background: ' . $value . '; }' : '' !!}
                {!! $index === 'time_col_text_odd' && $value ? '#eventSchedule .schedule-content-item .left-side.odd { color: ' . $value . '; }' : '' !!}
                {!! $index === 'border_color' && $value ? '#eventSchedule .schedule-content-item .right-side, #eventSchedule .room-content .content-items .content-row:last-child .schedule-content-item .right-side { border-color: ' . $value . '; }' : '' !!}
                {!! $index === 'border_style' && $value ? '#eventSchedule .schedule-content-item .right-side { border-top-style: ' . $value . '; } #eventSchedule .room-content .content-items .content-row:last-child .schedule-content-item .right-side { border-bottom-style: ' . $value . ' }' : '' !!}
                {!! $index === 'item_title' && $value ? '#eventSchedule .schedule-content-item .right-side .title, #eventSchedule .schedule-content-item .right-side .sub-items .sub-content-title { color: ' . $value . '; }' : '' !!}
                {!! $index === 'item_subtitle' && $value ? '#eventSchedule .schedule-content-item .right-side .subtitle, #eventSchedule .schedule-content-item .right-side .sub-items .sub-content-sub-title { color: ' . $value . '; }' : '' !!}
                {!! $index === 'item_button_bg' && $value ? '#eventSchedule .content-button a { background: ' . $value . '; }' : '' !!}
                {!! $index === 'item_button_text' && $value ? '#eventSchedule .content-button a { color: ' . $value . '; }' : '' !!}
                {!! $index === 'nav_bg_color' && $value ? '#kt_app_footer, .event-navigation > li > a, .event-navigation > li.logout > a, .event-navigation > li.admin-zone > a, .event-navigation > li > a.active { background: ' . $value . '; }' : '' !!}
                {!! $index === 'nav_buttons_color' && $value ? '.event-navigation > li > a, .event-navigation > li > a.active, .event-navigation > li > a:hover, .event-navigation > li > a:focus, .event-navigation > li > a svg, .event-navigation > li > a.active svg, .event-navigation > li > a:hover svg, .event-navigation > li > a:focus svg, .event-navigation > li > a svg path, .event-navigation > li > a.active svg path, .event-navigation > li > a:hover svg path, .event-navigation > li > a:focus svg path { color: ' . $value . '; stroke: ' . $value . '; fill: ' . $value . '; }' : '' !!}
                {!! $index === 'nav_buttons_border_color' && $value ? '.event-navigation > li { border-color: ' . $value . '; }' : '' !!}
            @endforeach
        @endif
    </style>
@stop

@section('content')
    @can('edit', $event)
        @include('frontend.events.parts.design_editor', [
            'settings' => $event->designSettings()
        ])
    @endcan

    <div id="eventLanding">
        <div class="container-xxl">
            <div class="row">
                @if (!$event->hideTitle())
                    <div class="col event-title">
                        @if ($event->showTitle())
                            <h1>{!! nl2br($event->getTitle()) !!}</h1>
                        @elseif ($event->showLogo() && $event->mediaFile())
                            <img src="{{ $event->mediaFile->getUrl() }}">
                        @endif
                    </div>
                @endif
            </div>
            <div class="">
                @yield('event_content')
            </div>
        </div>
    </div>
@endsection
