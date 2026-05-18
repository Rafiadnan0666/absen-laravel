<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Auth - ABS')</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <!-- Navbar -->
    <nav class="relative flex flex-wrap items-center justify-between px-4 py-3 mx-6 mt-4 transition-all duration-250 ease-soft-in rounded-2xl shadow-soft-xl bg-white">
        <a href="/" class="block px-0 py-2 m-0 text-lg whitespace-nowrap text-slate-700 font-bold">
            <i class="fas fa-fingerprint mr-2 text-purple-600"></i>
            {{ config('app.name', 'ABS') }}
        </a>

        <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                @guest
                    <li class="flex items-center">
                        <a href="{{ route('login') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs border-slate-300 leading-pro text-xs ease-soft-in tracking-tight-soft hover:bg-gray-100">
                            <i class="fas fa-sign-in-alt mr-1"></i> Log In
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>

    <main class="w-full px-6 py-12 mx-auto">
        <div class="flex items-center justify-center min-h-[70vh]">
            <div class="w-full max-w-md">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                    <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                        <h4 class="font-bold text-slate-700 text-center text-2xl">
                            @yield('header', 'Welcome')
                        </h4>
                    </div>
                    <div class="flex-auto p-6">
                        {{ $slot }}
                    </div>
                </div>
                
                <div class="text-center mt-6">
                    <a href="/" class="text-sm font-semibold text-slate-500 hover:text-slate-700">
                        <i class="fas fa-arrow-left mr-1"></i> Back to Home
                    </a>
                </div>
            </div>
        </div>
    </main>

    <!-- Plugin JS -->
    <script defer src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js') }}"></script>
</body>
</html>
