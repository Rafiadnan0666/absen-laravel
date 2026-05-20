<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth - ABS')</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-mono min-h-screen bg-neo-bg flex flex-col">
    <nav class="neo-container mt-4 mb-0">
        <div class="neo-card flex justify-between items-center">
            <a href="/" class="font-black text-xl">
                <span class="text-neo-purple">⚡</span> {{ config('app.name', 'ABS') }}
            </a>
            @guest
                <a href="{{ route('login') }}" class="neo-btn-primary neo-btn-sm">LOG IN</a>
            @endguest
        </div>
    </nav>

    <main class="flex-1 flex items-center justify-center p-8">
        <div class="w-full max-w-md">
            <div class="neo-card">
                <h4 class="font-black text-2xl text-center mb-6 border-b-3 border-black pb-4">
                    @yield('header', 'Welcome')
                </h4>
                {{ $slot }}
            </div>
            <div class="text-center mt-6">
                <a href="/" class="neo-btn-secondary neo-btn-sm">← BACK TO HOME</a>
            </div>
        </div>
    </main>
</body>
</html>