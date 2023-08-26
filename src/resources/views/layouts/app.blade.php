<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @if (\Request::is('/'))
            @yield('title', config('app.name', 'PenrithMRT'))
        @else
            @yield('title', config('app.name', 'PenrithMRT')) -- {{ config('app.name', 'PenrithMRT') }}
        @endif
    </title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700">
    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js']) @stack('scripts')
</head>

<body>
    <div id="app" class="bg-white">
        <nav class="navbar navbar-expand-md navbar-light pt-0">
            <div class="container-fluid p-5 align-items-start header-bg">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img width="160" height="160" class="d-inline-block align-top" alt="{{ config('app.name', 'PenrithMRT') }}" src="{{ asset('logo.png') }}" />
                </a>
                <div id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('callouts.index') }}">Callouts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('stay-safe') }}">Stay Safe</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('team') }}">The Team</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('get-involved') }}">Get Involved</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('news.index') }}">News</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('contact') }}">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('donate') }}">Donate</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <main>
            @yield('content')
        </main>
    </div>
</body>
<footer class="footer-wrap">
    <img class="footer-bg" src="{{ asset('mtn-decal.png') }}" />
    <div class="container">
        <div class="row">
            <div class="col-md-4 text-center">
                <h3>Contact</h3>
                <x-layout.contact.address/>
                <a href="mailto: secretary@penrithmrt.org.uk">Secretary@penrithmrt.org.uk</a>
                <x-layout.socials/>
            </div>
            <div class="col-md-4 text-center">
                <h3>Useful Links</h3>
                <ul class="list-unstyled">
                    <li>
                        <a class="nav-link footer-nav-link" href="{{ route('get-involved') }}">Join The Team</a>
                    </li>
                    <li>
                        <a class="nav-link footer-nav-link" href="{{ route('stay-safe') }}">Stay Safe</a>
                    </li>
                    <li>
                        <a class="nav-link footer-nav-link" href="{{ route('donate') }}">Donate</a>
                    </li>
                    <li>
                        <a class="nav-link footer-nav-link" href="{{ route('callouts.index') }}">Callouts</a>
                    </li>
                </ul>
            </div>
            <div class="col-md-4 text-center">
                <h3>Donate</h3>
                <p>
                    The Team rely on the generosity and support of the public. No matter how small your donation, it will allow the Team to stay operational and help those in need.
                </p>
                <x-layout.donate/>
            </div>
        </div>
        <div class="row text-center">
            <p>
                Penrith Mountain Rescue Team is a registered charity No. 505809
            </p>
        </div>
    </div>
</footer>

</html>
