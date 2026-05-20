<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>@yield('title', 'ABS')</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .auth-box { width: 100%; max-width: 400px; margin: 0 auto; }
        .auth-box.register { max-width: 500px; }
    </style>
</head>
<body class="font-mono bg-neo-bg min-h-screen flex items-center justify-center p-4">
    <div class="auth-box {{ Request::routeIs('register') ? 'register' : '' }}">
        <div class="neo-card">
            <div class="text-center mb-6">
                <div class="neo-avatar bg-neo-yellow text-black mx-auto mb-4">
                    <i class="fas fa-fingerprint"></i>
                </div>
                <h1 class="text-2xl font-black">{{ config('app.name', 'ABS') }}</h1>
                <p class="text-sm font-bold mt-2">@yield('subtitle', 'Welcome')</p>
            </div>

            @yield('content')

            @hasSection('footer')
            <div class="mt-6 pt-4 border-t-3 border-black">@yield('footer')</div>
            @endif

            <p class="text-center text-sm font-bold mt-6">© {{ date('Y') }} {{ config('app.name', 'ABS') }}</p>
        </div>
    </div>
</body>
</html>