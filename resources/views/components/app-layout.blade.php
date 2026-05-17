<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ABS') }} - @yield('title', 'Dashboard')</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-mono min-h-screen">
    <div class="min-h-screen">
        @include('layouts.navigation')

        @if(isset($header) || isset($title))
        <header class="neo-card mx-4 mt-4 mb-4 rounded-none">
            <div class="max-w-7xl mx-auto py-4 px-4">
                <h2 class="text-2xl font-black">
                    {{ $header ?? $title ?? 'Dashboard' }}
                </h2>
            </div>
        </header>
        @endif

        <main class="max-w-7xl mx-auto p-4">
            {{ $slot }}
        </main>
    </div>
</body>
</html>