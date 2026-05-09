<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ABS') }} - Attendance System</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Soft UI Dashboard CSS -->
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">
    <!-- Navbar -->
    <nav class="relative flex flex-wrap items-center justify-between px-4 py-3 mx-6 mt-4 transition-all duration-250 ease-soft-in rounded-2xl shadow-soft-xl bg-white">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
            <a href="/" class="block px-0 py-2 m-0 text-lg whitespace-nowrap text-slate-700 font-bold">
                <i class="fas fa-fingerprint mr-2 text-purple-600"></i>
                {{ config('app.name', 'ABS') }}
            </a>

            <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                    @if (Route::has('login'))
                        @auth
                            <li class="flex items-center">
                                <a href="{{ url('/dashboard') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft hover:bg-gray-100">
                                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                                </a>
                            </li>
                        @else
                            <li class="flex items-center">
                                <a href="{{ route('login') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs border-slate-300 leading-pro text-xs ease-soft-in tracking-tight-soft hover:bg-gray-100">
                                    <i class="fas fa-sign-in-alt mr-1"></i> Log in
                                </a>
                            </li>

                            @if (Route::has('register'))
                                <li class="flex items-center pl-4">
                                    <a href="{{ route('register') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
                                        <i class="fas fa-user-plus mr-1"></i> Register
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="w-full px-6 py-12 mx-auto">
        <div class="flex flex-wrap -mx-3 items-center">
            <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/2">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6">
                    <h1 class="text-4xl font-black mb-4 text-slate-700">Welcome to {{ config('app.name', 'ABS') }}</h1>
                    <p class="text-lg text-slate-500 mb-6">Modern Attendance & Employee Management System built with Laravel. Track attendance, manage leaves, process payroll, and more.</p>
                    
                    <div class="flex flex-wrap gap-4">
                        @guest
                            <a href="{{ route('login') }}" class="inline-block px-8 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-sm ease-soft-in tracking-tight-soft">
                                <i class="fas fa-sign-in-alt mr-2"></i> Get Started
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="inline-block px-8 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-sm ease-soft-in tracking-tight-soft">
                                <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
                            </a>
                        @endguest
                        <a href="https://laravel.com/docs" target="_blank" class="inline-block px-8 py-3 mb-0 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs border-slate-300 leading-pro text-sm ease-soft-in tracking-tight-soft">
                            <i class="fas fa-book mr-2"></i> Documentation
                        </a>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 lg:w-1/2">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border overflow-hidden">
                    <div class="bg-gradient-to-tl from-purple-700 to-pink-500 p-8 text-center">
                        <i class="fas fa-fingerprint text-white text-8xl mb-4"></i>
                        <h3 class="text-white font-bold text-2xl mb-2">ABS System</h3>
                        <p class="text-white/80 text-sm">Version {{ app()->version() }}</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-calendar-check text-3xl text-blue-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold">Attendance</h4>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-calendar-times text-3xl text-yellow-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold">Leave Management</h4>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-money-bill-wave text-3xl text-green-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold">Payroll</h4>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-chart-bar text-3xl text-purple-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold">Reports</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div class="mt-12">
            <h2 class="text-3xl font-black text-center mb-8 text-slate-700">Features</h2>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mb-6 md:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 text-center">
                        <div class="inline-block w-16 h-16 mb-4 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center">
                            <i class="fas fa-fingerprint text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2">Biometric Attendance</h4>
                        <p class="text-sm text-slate-500">Advanced biometric attendance tracking with face recognition support.</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mb-6 md:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 text-center">
                        <div class="inline-block w-16 h-16 mb-4 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center">
                            <i class="fas fa-mobile-alt text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2">Mobile Friendly</h4>
                        <p class="text-sm text-slate-500">Access your attendance and payroll information from anywhere.</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mb-6 md:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 text-center">
                        <div class="inline-block w-16 h-16 mb-4 text-center rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 flex items-center justify-center">
                            <i class="fas fa-shield-alt text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2">Secure & Reliable</h4>
                        <p class="text-sm text-slate-500">Built on Laravel with enterprise-grade security and reliability.</p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="w-full px-6 py-6 mx-auto mt-12">
        <div class="text-center">
            <p class="text-sm text-slate-400">
                © {{ date('Y') }} {{ config('app.name', 'ABS') }}. All rights reserved. 
                <a href="https://laravel.com" class="text-blue-500 hover:underline">Powered by Laravel</a>
            </p>
        </div>
    </footer>

    <!-- Plugin JS -->
    <script src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js') }}"></script>
</body>
</html>
