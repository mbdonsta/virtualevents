@extends('frontend.events.view')

@section('event_content')
    <div id="eventSchedule">
        <div class="day-filter">
            @foreach($eventDays as $index => $eventDay)
                <div class="me-3 action-buttons-holder {{ $index < 1 ? 'opened' : '' }}">
                    <a href="#eventDay-{{ $index }}" class="day-button-actions tab-btn">
                        {{ $eventDay->name }}
                    </a>
                </div>
            @endforeach
        </div>
        <div class="schedule-view">
            <div class="day-boxes">
                @foreach($eventDays as $index => $eventDay)
                    <div id="eventDay-{{ $index }}" class="day-box {{ $index === 0 ? 'opened' : '' }}">
                        <div class="rooms">
                            @foreach($eventDay->getContent()['rooms']['items'] as $roomIndex => $room)
                                <div class="me-3 action-buttons-holder">
                                    <a href="#eventDay-{{ $index }}-roomBox-{{ $roomIndex }}"
                                       class="day-button-actions tab-btn {{ $roomIndex < 1 ? 'opened' : '' }}">
                                        {{ $room['title'] }}
                                    </a>
                                </div>
                            @endforeach
                        </div>
                        <div class="room-boxes pt-15">
                            @foreach($eventDay->getContent()['rooms']['items'] as $roomIndex => $room)
                                <div id="eventDay-{{ $index }}-roomBox-{{ $roomIndex }}"
                                     class="room-content {{ $roomIndex < 1 ? 'opened' : '' }}">
                                    <div class="content-items">
                                        @foreach($room['content']['items'] as $contentRowIndex => $item)
                                            <div class="content-row">
                                                <div class="schedule-content-item style-{{ $item['type'] }}">
                                                    <div
                                                        class="left-side {{ $contentRowIndex % 2 === 0 ? 'odd' : 'even' }}">
                                                        <div class="left-side__content">
                                                            {{ $item['time'] }}
                                                        </div>
                                                    </div>
                                                    <div class="right-side">
                                                        @if ($item['type'] === 'default')
                                                            <div class="right-side__image">
                                                                <div>
                                                                    <div class="js-image-upload image-upload-box">
                                                                        <div class="image-box">
                                                                            <img
                                                                                src="{{ $item['file_url'] ? $item['file_url'] : asset('assets/images/imgplace.png') }}">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                        <div class="right-side__content">
                                                            <h3 class="title">{{ $item['title'] }}</h3>
                                                            @if ($item['type'] !== 'minimal')
                                                                <div class="subtitle">{{ $item['subtitle'] }}</div>
                                                            @endif
                                                            @if ($item['type'] === 'default' && $item['show_button'])
                                                                <div class="content-button">
                                                                    <a href="{{ $item['button_url'] }}"
                                                                       class="btn">{{ $item['button_text'] }}</a>
                                                                </div>
                                                            @endif
                                                            @if ($item['type'] === 'compact')
                                                                <div class="sub-items">
                                                                    @foreach($item['items'] as $subItem)
                                                                        <div class="content-sub-item">
                                                                            <div class="sub-time">
                                                                                {{ $subItem['time'] }}
                                                                            </div>
                                                                            <div class="sub-content">
                                                                                <div class="sub-content-title">
                                                                                    {{ $subItem['title'] }}
                                                                                </div>
                                                                                <div class="sub-content-sub-title">
                                                                                    {{ $subItem['subtitle'] }}
                                                                                </div>
                                                                                @if ($subItem['show_button'])
                                                                                    <div class="content-button">
                                                                                        <a href="{{ $subItem['button_url'] }}"
                                                                                           class="btn">{{ $subItem['button_text'] }}</a>
                                                                                    </div>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop
