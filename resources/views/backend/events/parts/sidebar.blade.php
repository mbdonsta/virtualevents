<div class="event-sidebar mb-10 pt-20 ">
    <div id="kt_aside" class="aside card">
        <!--begin::Aside menu-->
        <div class="aside-menu flex-column-fluid pe-4">
            <!--begin::Aside Menu-->
            <div class="my-5 mt-0 pe-4 me-n4" id="kt_aside_menu_wrapper">
                <!--begin::Menu-->
                <div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_aside_menu">
                    <div class="menu-item pt-5">
                        <!--begin:Menu content-->
                        <div class="menu-content">
                            <a href="{{ route('frontend.events.watch', ['slug' => $event->slug]) }}"
                               target="_blank"
                               class="btn btn-secondary w-100 btn-sm">{{ __('Preview event') }}</a>
                        </div>
                        <!--end:Menu content-->
                    </div>

                    @can('edit', $event)
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('General') }}</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.stats.event', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.stats.event' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Statistics') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.events.edit', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.events.edit' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Edit general info') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @can('create', [App\Model\EventProgram::class, $event])
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.program.index', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.program.index' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Event program') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @can('edit', [App\Model\EventEmail::class, $event])
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.emails.edit', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.emails.edit' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Invitation email') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @can('create', [App\Model\EventRoom::class, $event])
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">{{ __('Event rooms') }}</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.rooms.add', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.rooms.add' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Add new room') }}</span>
                            </a>
                            <!--end:Menu link-->
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.rooms.index', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.rooms.index' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Room list') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @can('create', [App\Model\EventUser::class, $event])
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span
                                    class="menu-heading fw-bold text-uppercase fs-7">{{ __('Event participants') }}</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.users.index', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.users.index' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Participants list') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                    @can('create', [App\Model\ExhibitionGroup::class, $event])
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span
                                    class="menu-heading fw-bold text-uppercase fs-7">{{ __('Exhibition') }}</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.groups.index', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.groups.index' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Groups list') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                        @can('create', [App\Model\ExhibitionStand::class, $event])
                            <!--begin:Menu item-->
                            <div data-kt-menu-trigger="click" class="menu-item">
                                <!--begin:Menu link-->
                                <a href="{{ route('backend.stands.index', ['event' => $event->id]) }}"
                                   class="menu-link {{ Route::currentRouteName() === 'backend.stands.index' ? 'active' : '' }}">
                                    <span class="menu-title">{{ __('Stands list') }}</span>
                                </a>
                                <!--end:Menu link-->
                            </div>
                            <!--end:Menu item-->
                        @endcan
                    @endcan
                    @can('create', [App\Model\EventPoster::class, $event])
                        <!--begin:Menu item-->
                        <div class="menu-item pt-5">
                            <!--begin:Menu content-->
                            <div class="menu-content">
                                <span
                                    class="menu-heading fw-bold text-uppercase fs-7">{{ __('Posters') }}</span>
                            </div>
                            <!--end:Menu content-->
                        </div>
                        <!--end:Menu item-->
                        <!--begin:Menu item-->
                        <div data-kt-menu-trigger="click" class="menu-item mb-5">
                            <!--begin:Menu link-->
                            <a href="{{ route('backend.posters.index', ['event' => $event->id]) }}"
                               class="menu-link {{ Route::currentRouteName() === 'backend.posters.index' ? 'active' : '' }}">
                                <span class="menu-title">{{ __('Posters list') }}</span>
                            </a>
                            <!--end:Menu link-->
                        </div>
                        <!--end:Menu item-->
                    @endcan
                </div>
                <!--end::Menu-->
            </div>
        </div>
        <!--end::Aside menu-->
    </div>

</div>
