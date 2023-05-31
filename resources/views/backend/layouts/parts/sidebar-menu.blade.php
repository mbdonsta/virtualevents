<!--begin::Menu wrapper-->
<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper hover-scroll-overlay-y my-5"
     data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto"
     data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer"
     data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px"
     data-kt-scroll-save-state="true">
    <!--begin::Menu-->
    <div class="menu menu-column menu-rounded menu-sub-indention px-3" id="#kt_app_sidebar_menu"
         data-kt-menu="true" data-kt-menu-expand="false">
        @can('seeList', App\Models\Event::class)
            <!--begin:Menu item-->
            <div data-kt-menu-trigger="click"
                 class="menu-item {{ Route::currentRouteName() === 'backend.events.index' ? 'here' : '' }}">
                <!--begin:Menu link-->
                <a class="menu-link" href="{{ route('backend.events.index') }}">
                <span class="menu-icon">
                    <!--begin::Svg Icon | path: icons/duotune/general/gen025.svg-->
                    <span class="svg-icon svg-icon-2">
                        <!--begin::Svg Icon | path: /var/www/preview.keenthemes.com/kt-products/docs/metronic/html/releases/2022-11-24-050857/core/html/src/media/icons/duotune/electronics/elc004.svg-->
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="currentColor"/>
                            <path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z"
                                  fill="currentColor"/>
                            <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="currentColor"/>
                        </svg>
                        <!--end::Svg Icon-->
                    </span>
                    <!--end::Svg Icon-->
                </span>
                    <span class="menu-title">{{ __('My Events') }}</span>
                </a>
                <!--end:Menu link-->
            </div>
            <!--end:Menu item-->
        @endcan
    </div>
    <!--end::Menu-->
</div>
<!--end::Menu wrapper-->
