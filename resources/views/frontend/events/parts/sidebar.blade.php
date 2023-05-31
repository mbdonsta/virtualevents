<div class="event-sidebar mb-10">
    <div id="kt_aside" class="aside card">
        <div class="aside-menu flex-column-fluid px-4">
            <div id="kt_aside_menu_wrapper" class="my-5 mt-0 pe-4 me-n4">
                <div id="#kt_aside_menu"
                     class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6">
                    <div class="menu-item pt-5">
                        <div class="menu-content">
                            <span class="menu-heading fw-bold text-uppercase fs-7">Event menu</span>
                        </div>
                    </div>
                    <div data-kt-menu-trigger="click" class="menu-item">
                        <a href="https://events.top/backend/events/1/edit"
                           class="menu-link {{ Route::currentRouteName() === 'frontend.event.program.view'? 'active' : '' }}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                    <svg width="16" height="15" viewBox="0 0 16 15" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect y="6" width="16" height="3" rx="1.5" fill="currentColor"/>
                                        <rect opacity="0.3" y="12" width="8" height="3" rx="1.5" fill="currentColor"/>
                                        <rect opacity="0.3" width="12" height="3" rx="1.5" fill="currentColor"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Program</span>
                        </a>
                    </div>
                    <div data-kt-menu-trigger="click" class="menu-item">
                        <a href="https://events.top/backend/events/1/edit"
                           class="menu-link  {{ Route::currentRouteName() === 'frontend.event.posters.view'? 'active' : '' }}">
                            <span class="menu-icon">
                                <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.3"
                                              d="M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z"
                                              fill="currentColor"/>
                                        <path
                                            d="M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z"
                                            fill="currentColor"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Posters</span>
                        </a>
                    </div>
                    <div data-kt-menu-trigger="click" class="menu-item">
                        <a href="{{ route('frontend.events.exhibition.view', ['slug' => $event->slug]) }}"
                           class="
                           menu-link {{ Route::currentRouteName() === 'frontend.event.exhibition.view' ? 'active' : '' }}
                        ">
                        <span class="menu-icon">
                                <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.5" x="7" y="2" width="14" height="16" rx="3"
                                              fill="currentColor"/>
                                        <rect x="3" y="6" width="14" height="16" rx="3" fill="currentColor"/>
                                    </svg>
                                </span>
                            </span>
                            <span class="menu-title">Exhibition</span>
                        </a>
                    </div>
                    @if ($event->hasRooms())
                        <div class="menu-item pt-5">
                            <div class="menu-content">
                                <span class="menu-heading fw-bold text-uppercase fs-7">
                                    Event rooms
                                </span>
                            </div>
                        </div>
                        @foreach($event->getRooms() as $eventRoom)
                            <div data-kt-menu-trigger="click" class="menu-item">
                                <a href="{{ route('frontend.events.room.view', ['slug' => $event->slug, 'eventRoom' => $eventRoom->id]) }}"
                                   class="menu-link {{ Route::input('eventRoom') && Route::currentRouteName() === 'frontend.event.room.view' && Route::input('eventRoom')->id === $eventRoom->id ? 'active' : '' }}">
                                    <span class="menu-icon">
                                        <span class="svg-icon svg-icon-muted svg-icon-2hx">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z"
                                                      fill="currentColor"/>
                                                <path opacity="0.3"
                                                      d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z"
                                                      fill="currentColor"/>
                                                <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="currentColor"/>
                                            </svg>
                                        </span>
                                    </span>
                                    <span class="menu-title">{{ $eventRoom->name }}</span>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
