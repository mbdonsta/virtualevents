@extends('frontend.events.view')

@section('event_content')
    <div class="exhibition-groups">
        @foreach ($exhibitionGroups as $exhibitionGroup)
            <div class="exhibition-groups__row mb-20">
                <div class="exhibition-groups__title mb-15 text-center">
                    <h2>{{ $exhibitionGroup->getTitle() }}</h2>
                </div>
                <div class="exhibition-groups__items row">
                    @foreach ($exhibitionGroup->exhibitionStands as $exhibitionStand)
                        <div class="col-md-{{ $exhibitionGroup->getColumns() }}">
                            <div class="exhibition-groups__items__item mb-10">
                                <div class="overlay">
                                    <a href="{{ route('frontend.events.exhibition.single', ['slug' => $event->slug, 'exhibitionStand' => $exhibitionStand->id]) }}">{{ __('Enter The Booth') }}</a>
                                </div>
                                <div class="image">
                                    <img
                                        src="{{ $exhibitionStand->featuredImage ? $exhibitionStand->featuredImage->getUrl() : url()->to('/') . '/uploads/sample.jpg' }}">
                                </div>
                                <div class="info">
                                    <div class="logo">
                                        <img
                                            src="{{ $exhibitionStand->mediaFile ? $exhibitionStand->mediaFile->getUrl() : '' }}">
                                    </div>
                                    <div class="title">
                                        <h3>{{ $exhibitionStand->name }}</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@stop
