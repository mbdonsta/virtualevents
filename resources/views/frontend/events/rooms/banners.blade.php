<div class="room-banners">
    <div id="kt_carousel_3_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel"
         data-bs-interval="2000">
        <!--begin::Carousel-->
        <div class="carousel-inner">
            @foreach ($banners as $index => $banner)
                @if ($banner->getBannerImageUrl())
                    <!--begin::Item-->
                    <div class="carousel-item {{ $index ===  0 ? 'active' : '' }}">
                        @if ($banner->isTypeDownloadFile())
                            <a href="{{ $banner->downloadFile->getUrl() }}" download>
                                @elseif ($banner->isTypeRedirectToUrl())
                                    <a href="{{ $banner->getRedirectUrl() }}" target="_blank">
                                        @elseif ($banner->isTypeYoutube())
                                            <a href="{{ $banner->youtube_url }}" class="mp-item-iframe">
                                                @else
                                                    <a>
                                                        @endif
                                                        <img src="{{ $banner->getBannerImageUrl() }}"
                                                             alt="{{ $eventRoom->event->getTitle() }}">
                                                    </a>
                    </div>
                    <!--end::Item-->
                @endif
            @endforeach
        </div>
        <!--end::Carousel-->
    </div>
</div>
