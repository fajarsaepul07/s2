<!DOCTYPE html>
<html class="no-js" lang="">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>@yield('pageTitle', 'Web Helpdesk')</title>
    <meta name="description" content="Sistem tiket modern untuk client dan vendor dengan SLA real-time." />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('user/css/bootstrap-5.0.0-beta1.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/LineIcons.2.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('user/css/lindy-uikit.css') }}" />

    @stack('styles')

    <style>
        :root{--primary:#0052CC;--secondary:#172B4D;--accent:#00B8D9;}

        .navbar-height { height: 70px !important; }

        .sidebar {
            width: 260px;
            height: calc(100vh - 70px);
            position: fixed;
            left: 0;
            top: 70px;
            background: #ffffff;
            border-right: 1px solid #e5e5e5;
            padding: 20px 15px 0;
            transition: all .3s ease;
            z-index: 9998;
        }

        .sidebar-inner {
            height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .logo h5,
        .sidebar.collapsed .sidebar-menu span {
            display: none !important;
        }

        .sidebar-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 15px;
            margin-bottom: 8px;
            border-radius: 10px;
            color: #333;
            font-weight: 600;
            text-decoration: none;
            transition: .2s;
            white-space: nowrap;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active {
            background: #EBF4FF;
            color: #0052CC;
        }

        .main-content {
            margin-left: 260px;
            padding-top: 0px;
            transition: margin-left .3s ease;
        }

        .sidebar.collapsed ~ .main-content {
            margin-left: 80px;
        }

        @media(max-width: 992px) {
            .sidebar { left: -260px; }
            .sidebar.show { left: 0; }
            .main-content { margin-left: 0; }
            .sidebar.show ~ .main-content { margin-left: 260px; }
        }
    </style>
</head>

<body>

    {{-- SIDEBAR --}}
    @include('layouts.components-frontend.sidebar')

    {{-- NAVBAR --}}
    @include('layouts.components-frontend.navbar')

    {{-- MAIN CONTENT --}}
    <div id="main-content" class="main-content">
        @yield('content')
    </div>

    {{-- Scroll Top --}}
    <a href="#" class="scroll-top"><i class="lni lni-chevron-up"></i></a>

    <!-- JS -->
    <script src="{{ asset('user/js/bootstrap-5.0.0-beta1.min.js') }}"></script>
    <script src="{{ asset('user/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('user/js/wow.min.js') }}"></script>
    <script src="{{ asset('user/js/main.js') }}"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            sidebar.classList.toggle('collapsed');
            sidebar.classList.toggle('show');
        }
    </script>

    @stack('scripts')
</body>
</html>