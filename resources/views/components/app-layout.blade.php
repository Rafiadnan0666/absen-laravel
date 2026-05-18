<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ABS') }} - @yield('title', 'Dashboard')</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <div class="min-h-screen">
        @include('layouts.navigation')

        @if(isset($header) || isset($title))
        <header class="bg-white shadow-soft-xl mx-4 mt-4 rounded-2xl">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <h2 class="text-2xl font-black text-slate-700">
                    {{ $header ?? $title ?? 'Dashboard' }}
                </h2>
            </div>
        </header>
        @endif

        <main class="max-w-7xl mx-auto p-4 sm:p-6">
            {{ $slot }}
        </main>
    </div>

    <script defer src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js') }}"></script>
</body>
</html>