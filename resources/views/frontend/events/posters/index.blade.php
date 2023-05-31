@extends('frontend.events.view')

@section('event_content')
    <div class="posters">
        <div class="row">
            @foreach($posters as $poster)
                <div class="col-md-4">
                    <div class="poster-item">
                        @if ($poster->posterImage)
                            <div class="image">
                                <img src="{{ $poster->getPosterImageUrl() }}">
                            </div>
                        @endif
                        <div class="description">
                            <h4>{{ $poster->description }}</h4>
                            <p>{{ __('Author') }}: {{ $poster->author }}</p>
                        </div>
                        @if ($poster->posterImage)
                            <div class="d-flex justify-content-between align-items-center">
                                <a class="view-btn btn btn-sm btn-primary"
                                   href="{{ $poster->getPosterImageUrl() }}">{{ __('View') }}</a>
                                @if (!$vote)
                                    @if (auth()->user()->id !== $event->user_id)
                                        <a class="btn btn-sm btn-info"
                                           href="{{ route('frontend.posters.vote', ['eventPoster' => $poster->id]) }}">
                                            {{ __('Vote') }}
                                        </a>
                                    @endif
                                @else
                                    <span>{{ $vote->model_id === $poster->id ? __('You voted for this') : __('Already voted') }}</span>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@stop
