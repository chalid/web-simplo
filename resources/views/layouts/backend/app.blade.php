<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <title>@yield('title', 'Admin Panel')</title> -->
     <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Block SEO indexing for backend --}}
    <meta name="robots" content="noindex, nofollow" />
    <meta name="author" content="Admin" />
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/frontend/assets/img/favicon.ico/apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/frontend/assets/img/favicon.ico/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/frontend/assets/img/favicon.ico/favicon-16x16.png') }}">
    <link rel="manifest" href="{{ asset('assets/frontend/assets/img/favicon.ico/site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('assets/frontend/assets/img/favicon.ico/safari-pinned-tab.svg') }}" color="#5bbad5">
    {{-- No canonical for backend, or can set to app url --}}
    <link rel="canonical" href="{{ url()->current() }}" />

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @include('layouts.backend.partials.head')
</head>
<body>
    <main id="main-wrapper" class="main-wrapper">
        @include('layouts.backend.partials.header')
        @include('layouts.backend.partials.sidenav')
        <!-- Page Content -->
        <div id="app-content">
            <!-- Container fluid -->
            <div class="app-content-area">
                <div class="container-fluid">
                    @include('layouts.backend.partials.alert')
                    @yield('content')
                </div>
            </div>
        </div>
    </main>
    @include('layouts.backend.partials.script')
    @stack('scripts')
</body>
</html>