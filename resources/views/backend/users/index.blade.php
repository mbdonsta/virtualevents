@extends('backend.events.parts.wrapper')

@section('event_wrapper_content')
    <div class="pt-20 card card-flush">
        <div class="px-8">
            @include('global.notices')
        </div>
        <!--begin::Card header-->
        @if ($eventUsers->isEmpty() && !request('keyword'))
            <div class="card-body">
                <p class="text-center">{{ __("This event do not have any participants.") }}</p>
                @can('create', [App\Model\EventUser::class, $event])
                    <div class="text-center">
                        <a href="{{ route('backend.users.add', ['event' => $event->id]) }}"
                           class="btn btn-primary">{{ __('Add participant') }}</a>
                        <a href="{{ route('backend.users.import', ['event' => $event->id]) }}"
                           class="btn btn-primary">{{ __('Import participants') }}</a>
                    </div>
                @endcan
            </div>
        @else
            <div class="card-header align-items-center py-5 gap-2 gap-md-5">
                <!--begin::Card title-->
                <div class="card-title">
                    <!--begin::Search-->
                    <div class="d-flex align-items-center position-relative my-1">
                        <form action="" method="GET">
                            <input type="text" data-kt-ecommerce-order-filter="search"
                                   name="keyword"
                                   class="form-control form-control-solid w-250px ps-14"
                                   placeholder="{{ __('Search for participant') }}"
                                   value="{{ request('keyword') }}">
                        </form>
                    </div>
                    <!--end::Search-->
                </div>
                <!--end::Card title-->
                @can('create', [App\Model\EventUser::class, $event])
                    <!--begin::Card toolbar-->
                    <div class="card-toolbar flex-row-fluid justify-content-end gap-5">
                        <a href="{{ route('backend.users.add', ['event' => $event->id]) }}"
                           class="btn btn-secondary btn-sm"
                           onclick="return confirm('{{ __('Are you sure you want to send invitations to all event participants?') }}')"
                        >{{ __('Invite users') }}</a>
                        <a href="{{ route('backend.users.add', ['event' => $event->id]) }}"
                           class="btn btn-primary btn-sm">{{ __('Add participant') }}</a>
                        <a href="{{ route('backend.users.import', ['event' => $event->id]) }}"
                           class="btn btn-primary btn-sm">{{ __('Import participants') }}</a>
                    </div>
                    <!--end::Card toolbar-->
                @endif
            </div>
            <!--end::Card header-->
            <!--begin::Card body-->
            <div class="card-body pt-0">
                {{ $eventUsers->links() }}
                <!--begin::Table-->
                <div id="kt_ecommerce_sales_table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">

                    <div class="table-responsive overflow-visible">
                        <table class="table align-middle table-row-dashed events-table fs-7 gy-3 no-footer"
                               id="kt_ecommerce_sales_table">
                            <!--begin::Table head-->
                            <thead>
                            <!--begin::Table row-->
                            <tr class="text-start text-gray-400 fw-bold fs-7 text-uppercase gs-0">
                                <th class="min-w-175px sorting">{{ __('Participant name') }}</th>
                                <th class="min-w-175px sorting">{{ __('Participant email') }}</th>
                                <th class="min-w-175px">{{ __('Access number') }}</th>
                                <th class="sorting text-center">{{ __('Invited') }}</th>
                                <th class="text-end min-w-100px sorting_disabled">{{ __('Actions') }}</th>
                            </tr>
                            <!--end::Table row-->
                            </thead>
                            <!--end::Table head-->
                            <!--begin::Table body-->
                            <tbody class="fw-semibold text-gray-600">
                            @foreach ($eventUsers as $eventUser)
                                <tr class="odd">
                                    <td>
                                        <div class="d-flex align-items-center">
                                            {{ $eventUser->getFullName() }}
                                        </div>
                                    </td>
                                    <td class="">
                                        <div class="d-flex align-items-center">
                                            {{ $eventUser->user->getEmail() }}
                                        </div>
                                    </td>
                                    <td>
                                        {{ $eventUser->access_number }}
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            {{ $eventUser->isInvited() ? __('Yes') : __('No') }}
                                        </div>
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
                                                @can('edit', $eventUser)
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item py-0">
                                                        <a href="{{ route('backend.users.edit', ['eventUser' => $eventUser->id]) }}"
                                                           class="menu-link px-3">{{ __('Edit') }}</a>
                                                    </div>
                                                    <!--end::Menu item-->
                                                @endcan
                                                @can('delete', $eventUser)
                                                    <div class="separator"></div>
                                                    <!--begin::Menu item-->
                                                    <div class="menu-item py-0">
                                                        <a href="{{ route('backend.users.delete', ['eventUser' => $eventUser->id]) }}"
                                                           class="menu-link px-3"
                                                           onclick="return confirm('{{ __('Are you sure you want to delete :name event participant?', ['name' => $eventUser->user->getFullName()]) }}')"
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
                        {{ $eventUsers->appends([
                            'keyword' => request('keyword')
                        ])->links() }}
                    </div>

                </div>
                <!--end::Table-->
            </div>
            <!--end::Card body-->
        @endif
    </div>
@stop
