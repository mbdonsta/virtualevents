@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 px-8 d-flex justify-content-between align-items-center flex-wrap">
        <div class="w-100">
            @include('global.notices')
        </div>
        <a href="{{ route('backend.stands.index', ['event' => $event]) }}"
           class="btn btn-primary btn-sm">{{ __('Back to stands') }}</a>
    </div>

    <div class="card card-flush mb-3">
        <!--begin::Card body-->
        <div class="card-body">
            <form action="{{ route('backend.stands.update', ['exhibitionStand' => $exhibitionStand->id]) }}"
                  method="POST">
                @csrf
                @method('PATCH')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Stand name') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   name="name" value="{{ old('name', $exhibitionStand->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">
                                {{ __('Exhibition group') }}
                                <small class="text-gray-400">({{ __('required') }})</small>
                            </label>
                            <select class="form-select @error('exhibition_group_id') is-invalid @enderror"
                                    name="exhibition_group_id">
                                @foreach ($exhibitionGroups as $exhibitionGroup)
                                    <option
                                        value="{{ $exhibitionGroup->id }}" {{ $exhibitionGroup->id == old('exhibition_group_id', $exhibitionStand->exhibition_group_id) ? 'selected' : '' }}>
                                        {{ $exhibitionGroup->getTitle() }}
                                    </option>
                                @endforeach
                            </select>
                            @error('exhibition_group_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Stand logo') }}</label>
                            <image-upload
                                route="{{ route('backend.stands.logo_upload', ['event' => $event->id]) }}"
                                file_id="{{ old('media_file_id', $exhibitionStand->media_file_id) }}"
                                file_url="{{ $exhibitionStand->mediaFile ? old('media_file_url', $exhibitionStand->mediaFile->getUrl()) : old('media_file_url') }}"
                                field_name="media_file_id"
                                field_url_name="media_file_url"
                                fit="1"
                            ></image-upload>
                            @error('media_file_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-10">
                            <label class="form-label">{{ __('Stand featured image') }}</label>
                            <image-upload
                                route="{{ route('backend.stands.logo_upload', ['event' => $event->id]) }}"
                                file_id="{{ old('featured_image_id', $exhibitionStand->featured_image_id) }}"
                                file_url="{{ $exhibitionStand->featuredImage ? old('featured_image_url', $exhibitionStand->featuredImage->getUrl()) : old('featured_image_url') }}"
                                field_name="featured_image_id"
                                field_url_name="featured_image_url"
                            ></image-upload>
                            @error('featured_image_id')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    {{--                    <div class="col-12">--}}
                    {{--                        <div class="mb-10">--}}
                    {{--                            <label class="form-label">{{ __('Stand layout') }}</label>--}}
                    {{--                            <!--begin::Radio group-->--}}
                    {{--                            <div data-kt-buttons="true" class="stand-layout-selection row">--}}
                    {{--                                @foreach($layouts as $value => $layout)--}}
                    {{--                                    <div class="col-md-3">--}}
                    {{--                                        @include('backend.stands.parts.layout_radio_' . $value, ['current' => $exhibitionStand->layout_style, 'value' => $value])--}}
                    {{--                                    </div>--}}
                    {{--                                @endforeach--}}
                    {{--                            </div>--}}
                    {{--                            <!--end::Radio group-->--}}
                    {{--                            @error('layout_style')--}}
                    {{--                            <div class="invalid-feedback d-block">{{ $message }}</div>--}}
                    {{--                            @enderror--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <div class="col-12">
                        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
                            <!--begin::Indicator label-->
                            <span class="indicator-label">{{ __('Submit') }}</span>
                            <!--end::Indicator label-->
                            <!--begin::Indicator progress-->
                            <span class="indicator-progress">{{ __('Please wait...') }}
                                    <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                </span>
                            <!--end::Indicator progress-->
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="px-8">
        <div class="card card-flush stand-items-card border">
            <div class="card-header align-items-center">
                <h3 class="card-title">
                    {{ __('Stand items') }}
                    <small class="text-gray-400">
                        ({{ __('max :num items', ['num' => $layouts[$exhibitionStand->layout_style] ?? 1]) }}
                        )
                    </small>
                </h3>
                <a href="{{ route('backend.stand_items.add', ['exhibitionStand' => $exhibitionStand->id]) }}"
                   class="btn btn-sm btn-primary">{{ __('Create item') }}</a>
            </div>
            <div class="card-body p-0 stand-items"
                 data-reorder-route="{{ route('backend.stand_items.reorder', ['exhibitionStand' => $exhibitionStand->id]) }}">
                @foreach ($exhibitionStand->items as $index => $exhibitionStandItem)
                    @if ($index >= \App\Models\ExhibitionStand::STAND_LAYOUTS[$exhibitionStand->layout_style])
                        @continue
                    @endif
                    <div class="stand-item" data-id="{{ $exhibitionStandItem->id }}">
                        <div class="handle">
                            <i class="las la-braille"></i>
                        </div>
                        <div class="number index-{{ $exhibitionStandItem->id }}">{{ $index + 1 }}</div>
                        <div class="banner">
                            @if ($exhibitionStandItem->getBannerImageUrl())
                                <img src="{{ $exhibitionStandItem->getBannerImageUrl() }}">
                            @endif
                        </div>
                        <div class="name">
                            <div>
                                <small class="d-block"><strong>{{ __('Name') }}</strong></small>
                                {{ $exhibitionStandItem->name }}
                            </div>
                        </div>
                        <div class="behaviour">
                            <div>
                                <small class="d-block"><strong>{{ __('On click behaviour') }}</strong></small>
                                {{ $exhibitionStandItem->getOnClickBehaviour() }}
                            </div>
                        </div>
                        <div class="actions">
                            <div class="action-dropdown">
                                <a href="#"
                                   class="js-dropdown-toggle btn btn-sm btn-light btn-active-light-primary">{{ __('Actions') }}
                                    <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                    <span class="svg-icon svg-icon-5 m-0">
                                    <svg width="24" height="24" viewBox="0 0 24 24"
                                         fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                            fill="currentColor">
                                        </path>
                                    </svg>
                                </span>
                                </a>
                                <!--begin::Menu-->
                                <div
                                    class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px"
                                    data-kt-menu="true">
                                    @can('edit', $exhibitionStandItem)
                                        <!--begin::Menu item-->
                                        <div class="menu-item py-0">
                                            <a href="{{ route('backend.stand_items.edit', ['exhibitionStandItem' => $exhibitionStandItem->id]) }}"
                                               class="menu-link px-3">{{ __('Edit') }}</a>
                                        </div>
                                        <!--end::Menu item-->
                                    @endcan
                                    @can('delete', $exhibitionStandItem)
                                        <div class="separator"></div>
                                        <!--begin::Menu item-->
                                        <div class="menu-item py-0">
                                            <a href="{{ route('backend.stand_items.delete', ['exhibitionStandItem' => $exhibitionStandItem->id]) }}"
                                               class="menu-link px-3"
                                               onclick="return confirm('{{ __('Are you sure you want to delete :title exhibition stand item?', ['title' => $exhibitionStandItem->name]) }}')"
                                            >{{ __('Delete') }}</a>
                                        </div>
                                        <!--end::Menu item-->
                                    @endcan
                                </div>
                                <!--end::Menu-->
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.11/lib/draggable.bundle.js"></script>
@stop
