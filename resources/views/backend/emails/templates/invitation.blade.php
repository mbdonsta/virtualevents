@component('mail::layout')
    {{-- Header --}}
    @section('mail_styles')
        <style>
            @if (isset($eventEmail->getStyles()['bg_color']))
        body, .wrapper, .content .body {
                @if (isset($eventEmail->getStyles()['bg_color']) && $eventEmail->getStyles()['bg_color'])
                          background: {{ $eventEmail->getStyles()['bg_color'] }}                 !important;
            @endif


            }

            @endif
        @if (isset($eventEmail->getStyles()['content_bg_color']) || isset($eventEmail->getStyles()['content_text_color']))
        .inner-body {
                @if (isset($eventEmail->getStyles()['content_bg_color']) && $eventEmail->getStyles()['content_bg_color'])
       background: {{ $eventEmail->getStyles()['content_bg_color'] }}              !important;
                @endif
                @if (isset($eventEmail->getStyles()['content_text_color']) && $eventEmail->getStyles()['content_text_color'])
       color: {{ $eventEmail->getStyles()['content_text_color'] }}              !important;
            @endif


            }
            @endif
        </style>
    @endsection
    @slot('header')
        @component('mail::header', ['url' => url()->to('/')])
            @if ($eventEmail->event->mediaFile && $eventEmail->event->mediaFile->getUrl())
                <img class="logo-image" src="{{ $eventEmail->event->mediaFile->getUrl() }}">
            @else
                <h1>{{ $eventEmail->event->getTitle() }}</h1>
            @endif
        @endcomponent
    @endslot

    {!! $content !!}

    {{-- Footer --}}
    @slot('footer')
    @endslot
@endcomponent
