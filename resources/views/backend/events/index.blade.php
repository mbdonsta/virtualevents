@extends('backend.layouts.app')

@section('content')
    @include('backend.components.page_title', ['title' => __('My Events')])
    <div class="container-xxl">
        <div class="row">
            <div class="col py-15">
                @include('global.notices')
                @if ($events->isEmpty())
                    <div class="alert alert-primary d-flex align-items-center justify-content-between">
                        <h3 class="mb-0">{{ __("You don't have any events") }}</h3>
                        @can('create', App\Model\Event::class)
                            <a href="{{ route('backend.events.add') }}"
                               class="btn btn-primary">{{ __('Create event') }}</a>
                        @endcan
                    </div>
                @else
                    <div class="card-header d-flex justify-content-between align-items-center py-5 gap-2 gap-md-5">
                        <!--begin::Card title-->
                        <div class="card-title">
                            <!--begin::Search-->
                            <div class="d-flex align-items-center position-relative my-1">
                                <input type="text" data-kt-ecommerce-order-filter="search"
                                       class="form-control form-control-solid w-250px ps-14"
                                       placeholder="{{ __('Search for event') }}">
                            </div>
                            <!--end::Search-->
                        </div>
                        <!--end::Card title-->
                        @can('create', App\Model\Event::class)
                            <!--begin::Card toolbar-->
                            <div class="card-toolbar justify-content-end gap-5">
                                <!--begin::Add product-->
                                <a href="{{ route('backend.events.add') }}"
                                   class="btn btn-primary">{{ __('Create event') }}</a>
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
                                <table class="table align-middle table-row-dashed events-table fs-6 gy-5 no-footer"
                                       id="kt_ecommerce_sales_table">
                                    <!--begin::Table head-->
                                    <thead>
                                    <!--begin::Table row-->
                                    <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                        <th class="min-w-100px sorting">{{ __('Event ID') }}</th>
                                        <th class="min-w-175px sorting title-column">{{ __('Event title') }}</th>
                                        <th class="text-center min-w-175px sorting">{{ __('Event type') }}</th>
                                        <th class="text-center min-w-70px sorting">{{ __('Begins') }}</th>
                                        <th class="text-center min-w-100px sorting">{{ __('Ends') }}</th>
                                        <th class="text-center min-w-100px sorting">{{ __('Status') }}</th>
                                        <th class="text-end min-w-100px sorting_disabled">{{ __('Actions') }}</th>
                                    </tr>
                                    <!--end::Table row-->
                                    </thead>
                                    <!--end::Table head-->
                                    <!--begin::Table body-->
                                    <tbody class="fw-semibold text-gray-600">
                                    @foreach ($events as $event)
                                        <tr class="odd">
                                            <td data-kt-ecommerce-order-filter="order_id">{{ $event->id }}</td>
                                            <td class="title-column">
                                                <div class="d-flex align-items-center">
                                            <span class="badge bg-{{ $event->plan->getTypeSlug() }} me-2">
                                                {{ __(':name plan', ['name' => $event->plan->name]) }}
                                            </span> {{ $event->getTitle() }}
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $event->getVisibility() }}</td>
                                            <td class="text-center">{{ $event->getBeginDateTime('Y M d H:i') }}</td>
                                            <td class="text-center">{{ $event->getEndDateTime('Y M d H:i') }}</td>
                                            <td class="text-center pe-0" data-order="Completed">
                                                <div
                                                    class="badge badge-{{ $event->getStatusSlug() }}">{{ $event->getStatus() }}</div>
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
                                                        @can('view', $event)
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item py-0">
                                                                <a href="{{ $event->getUrl() }}"
                                                                   target="_blank"
                                                                   class="menu-link px-3">{{ __('View') }}</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        @endcan
                                                        @can('edit', $event)
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item py-0">
                                                                <a href="{{ route('backend.events.edit', ['event' => $event->id]) }}"
                                                                   class="menu-link px-3">{{ __('Edit') }}</a>
                                                            </div>
                                                            <!--end::Menu item-->
                                                        @endcan
                                                        @can('delete', $event)
                                                            <div class="separator"></div>
                                                            <!--begin::Menu item-->
                                                            <div class="menu-item py-0">
                                                                <a href="{{ route('backend.events.delete', ['event' => $event->id]) }}"
                                                                   class="menu-link px-3"
                                                                   onclick="return confirm('{{ __('Are you sure you want to delete :title event?', ['title' => $event->getTitle()]) }}')"
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
                            <div class="row">
                                {{ $events->links() }}
                            </div>

                        </div>
                        <!--end::Table-->
                    </div>
                    <!--end::Card body-->
                @endif
            </div>
        </div>
    </div>
@stop
