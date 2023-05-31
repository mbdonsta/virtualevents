@extends('frontend.events.view')

@section('event_content')
    <div class="exhibition-stand">
        <div class="featured-image">
            <img src="{{ url()->to('/') }}/uploads/sample.jpg">
            <div class="logo">
                <img src="{{ url()->to('/') }}/uploads/pfizer.png">
            </div>
            <div class="exhibition-groups__title">
                <h1 class="exhibition-groups__title__single">{{ $exhibitionStand->name }}</h1>
            </div>
        </div>
        <div class="stand-items row">
            @foreach($exhibitionStand->items as $item)
                @if ($item->bannerImage)
                    <div class="col-md-6">
                        <a class="stand-item" {{ $item->getDownloadFileUrl() ? 'href=' . $item->getDownloadFileUrl() . ' download' : '' }}>
                            <img src="{{ $item->banner_image_url }}">
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@stop
