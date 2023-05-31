@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')

    <div class="card pt-20 card-flush">
        <!--begin::Card header-->
        <div class="px-8">
            @include('global.notices')
        </div>
        @if ($eventPosters->isEmpty())
            <div class="card-body">
                <p class="text-center">{{ __("This event do not have any posters.") }}</p>
                @can('create', [App\Model\EventPoster::class, $event])
                    <div class="text-center">
                        <a href="{{ route('backend.posters.add', ['event' => $event->id]) }}"
                           class="btn btn-primary">{{ __('Create poster') }}</a>
                    </div>
                @endcan
            </div>
        @else
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                </div>
                <!--end::Card title-->
                @can('create', [App\Model\EventPoster::class, $event])
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <!--begin::Add product-->
                        <a href="{{ route('backend.posters.add', ['event' => $event->id]) }}"
                           class="btn btn-primary">{{ __('Create poster') }}</a>
                        <!--end::Add product-->
                    </div>
                    <!--end::Card toolbar-->
                @endif
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                <!--begin::Table-->
                <div id="kt_ecommerce_sales_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                    <div class="table-responsive overflow-visible">
                        <table class="table align-middle table-row-dashed posters-table fs-6 gy-5 no-footer"
                               id="kt_ecommerce_sales_table"
                               data-reorder-route="{{ route('backend.posters.reorder', ['event' => $event->id]) }}">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="handle"></th>
                                <th class="min-w-100px sorting">{{ __('Poster image') }}</th>
                                <th class="sorting">{{ __('Poster author') }}</th>
                                <th class="sorting title-column">{{ __('Poster description') }}</th>
                                <th class="text-center sorting">{{ __('Votes') }}</th>
                                <th class="text-end min-w-125px sorting_disabled">{{ __('Actions') }}</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                            @foreach ($eventPosters as $eventPoster)
                                <tr class="odd" data-id="{{ $eventPoster->id }}">
                                    <td class="handle">
                                        <div class="handle-icon">
                                            <i class="las la-braille"></i>
                                        </div>
                                    </td>
                                    <td>
                                        @if ($eventPoster->getPosterImageUrl())
                                            <div class="image-box">
                                                <img src="{{ $eventPoster->getPosterImageUrl() }}">
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{ $eventPoster->author }}
                                        </div>
                                    </td>
                                    <td class="title-column">
                                        <div class="d-flex align-items-center">
                                            {{ $eventPoster->description }}
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        {{ count($eventPoster->votes) }}
                                    </td>
                                    <td class="text-end">
                                        <div class="action-dropdown">
                                            <a href="#"
                                               class="js-dropdown-toggle btn btn-sm btn-light btn-active-light-primary">{{ __('Actions') }}
                                                <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
                                                <span class="svg-icon svg-icon-5 m-0">
                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                             fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z"
                                                fill="currentColor"></path>
                                        </svg>
                                    </span>
                                            </a>
                                            <!--begin::Menu-->
                                            <div
                                                class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px"
                                                data-kt-menu="true">
                                                @can('edit', $eventPoster)
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item py-0">
                                                        <a href="{{ route('backend.posters.edit', ['eventPoster' => $eventPoster->id]) }}"
                                                           class="menu-link px-3">{{ __('Edit') }}</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                @endcan
                                                @can('delete', $eventPoster)
                                                    <div class="separator"></div>
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item py-0">
                                                        <a href="{{ route('backend.posters.delete', ['eventPoster' => $eventPoster->id]) }}"
                                                           class="menu-link px-3"
                                                           onclick="return confirm('{{ __('Are you sure you want to delete event poster?') }}')"
                                                        >{{ __('Delete') }}</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                @endcan
                                            </div>
                                            <!--end::Menu-->
                                        </div>
                                    </td>
                                    <!--end::Action=-->
                                </tr>
                            @endforeach
                            </tbody>
                            <!--end::Table body-->
                        </table>
                    </div>

                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        @endif
    </div>
@stop

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/@shopify/draggable@1.0.0-beta.11/lib/draggable.bundle.js"></script>
@stop
