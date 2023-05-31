<!DOCTYPE html>
<html lang="en">
<!--begin::Head-->
<head>
    <base href="../"/>
    <title>@yield('title')</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700"/>
    <link rel="stylesheet" href="{{ mix('assets/css/frontend.css') }}">
</head>
<body id="kt_app_body" data-kt-app-layout="light-header" data-kt-app-header-fixed="true"
      data-kt-app-toolbar-enabled="true" class="app-default">
<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
    <div class="app-page flex-column flex-column-fluid" id="kt_app_page">
        @yield('content')
    </div>
    <!--end::Page-->
</div>
<!--end::App-->
<!--begin::Javascript-->
<script src="{{ mix('assets/js/frontend.js') }}" defer></script>
<!--end::Javascript-->
</body>
<!--end::Body-->
</html>
