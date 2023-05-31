<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href=""/>
    <title>
        {{ $pageTitle ?? 'Page' }} - Streamie
    </title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="shortcut icon" href="assets/media/logos/favicon.ico"/>
    <!--begin::Fonts(mandatory for all pages)-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900"/>
    <!--end::Fonts-->
    <link rel="stylesheet" href="{{ mix('assets/css/backend.css') }}">
</head>
<!--end::Head-->
<!--begin::Body-->
<body>
<!--begin::App-->
<div id="app">
    <header id="header">
        <div class="container-xxl">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a class="logo" href="{{ route('backend.events.index') }}">
                        <img src="{{ asset('assets/images/logo.png') }}">
                    </a>
                </div>
                <div class="col">
                    <nav id="navigation">
                        @can('seeList', App\Models\Event::class)
                            <a href="{{ route('backend.events.index') }}">
                                {{ __('My Events') }}
                            </a>
                        @endcan
                    </nav>
                </div>
                <div class="col-auto">
                    @auth
                        <a class="logout" href="{{ route('logout') }}">
                            {{ __('Log out') }}
                        </a>
                    @endauth
                    @guest
                        <a class="btn btn-primary rounded-pill"
                           href="https://www.streamie.eu{{ app()->isLocale('lt') ? '/lt' : '' }}">
                            {{ __('About Streamie') }}
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </header>
    <div id="#content">
        @yield('content')
    </div>
</div>
<!--end::App-->
<!--begin::Javascript-->
<script src="{{ mix('assets/js/backend.js') }}" defer></script>
@yield('scripts')
<!--end::Javascript-->
@if (auth()->check() && !auth()->user()->isAdmin())
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function () {
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/6458e7516a9aad4bc579823d/1gvtkf5rp';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
@endif
</body>
<!--end::Body-->
</html>
