<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ config('app.name', 'ABS') }} - Modern Attendance & Employee Management System">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}">
    <title>{{ config('app.name', 'ABS') }} - Attendance & Employee Management System</title>
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .hero-pattern {
            background-color: #ffffff;
            background-image: radial-gradient(circle at 20% 50%, rgba(124, 58, 237, 0.05) 0%, transparent 50%),
                              radial-gradient(circle at 80% 20%, rgba(219, 39, 119, 0.05) 0%, transparent 50%);
        }
    </style>
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default hero-pattern text-slate-500">
    <nav class="relative flex flex-wrap items-center justify-between px-4 py-3 mx-6 mt-4 transition-all duration-250 ease-soft-in rounded-2xl shadow-soft-xl bg-white/80 backdrop-blur-sm">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
            <a href="/" class="block px-0 py-2 m-0 text-xl whitespace-nowrap text-slate-700 font-black">
                <i class="fas fa-fingerprint mr-2 text-purple-600"></i>
                {{ config('app.name', 'ABS') }}
            </a>

            <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full gap-3">
                    @if (Route::has('login'))
                        @auth
                            <li class="flex items-center">
                                <a href="{{ url('/dashboard') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft">
                                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                                </a>
                            </li>
                        @else
                            <li class="flex items-center">
                                <a href="{{ route('login') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs border-slate-300 leading-pro text-xs ease-soft-in tracking-tight-soft hover:bg-gray-50">
                                    <i class="fas fa-sign-in-alt mr-1"></i> Login
                                </a>
                            </li>
                            @if (Route::has('register'))
                                <li class="flex items-center">
                                    <a href="{{ route('register') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-xs ease-soft-in tracking-tight-soft">
                                        <i class="fas fa-user-plus mr-1"></i> Get Started
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <main class="w-full px-6 py-12 mx-auto">
        <div class="flex flex-wrap -mx-3 items-center">
            <div class="w-full max-w-full px-3 mb-8 lg:mb-0 lg:w-1/2">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-8">
                    <span class="text-purple-600 font-bold text-sm uppercase tracking-wider mb-2">Attendance Management System</span>
                    <h1 class="text-4xl font-black mb-4 text-slate-700">Modern Employee Management Solution</h1>
                    <p class="text-lg text-slate-500 mb-6">Track attendance, manage leaves, process payroll, and monitor employee performance all in one powerful system.</p>
                    
                    <div class="flex flex-wrap gap-4">
                        @guest
                            <a href="{{ route('register') }}" class="inline-block px-8 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-sm ease-soft-in tracking-tight-soft">
                                <i class="fas fa-rocket mr-2"></i> Start Free Trial
                            </a>
                            <a href="{{ route('login') }}" class="inline-block px-8 py-3 mb-0 font-bold text-center text-slate-700 uppercase align-middle transition-all bg-transparent border border-solid rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs border-slate-300 leading-pro text-sm ease-soft-in tracking-tight-soft">
                                <i class="fas fa-play mr-2"></i> Watch Demo
                            </a>
                        @else
                            <a href="{{ url('/dashboard') }}" class="inline-block px-8 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-700 to-pink-500 leading-pro text-sm ease-soft-in tracking-tight-soft">
                                <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
                            </a>
                        @endguest
                    </div>

                    <div class="flex items-center gap-6 mt-8">
                        <div class="text-center">
                            <span class="block text-2xl font-black text-slate-700">500+</span>
                            <span class="text-xs text-slate-400">Active Users</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-black text-slate-700">99.9%</span>
                            <span class="text-xs text-slate-400">Uptime</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-2xl font-black text-slate-700">24/7</span>
                            <span class="text-xs text-slate-400">Support</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-full max-w-full px-3 lg:w-1/2">
                <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border overflow-hidden">
                    <div class="bg-gradient-to-tl from-purple-700 to-pink-500 p-8 text-center">
                        <i class="fas fa-fingerprint text-white text-8xl mb-4"></i>
                        <h3 class="text-white font-black text-3xl mb-2">{{ config('app.name', 'ABS') }}</h3>
                        <p class="text-white/80 text-sm">Version 1.0.0 | Enterprise Edition</p>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-colors cursor-pointer">
                                <i class="fas fa-calendar-check text-3xl text-blue-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold text-sm">Smart Attendance</h4>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-colors cursor-pointer">
                                <i class="fas fa-calendar-times text-3xl text-yellow-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold text-sm">Leave Management</h4>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-colors cursor-pointer">
                                <i class="fas fa-money-bill-wave text-3xl text-green-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold text-sm">Payroll Processing</h4>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl hover:bg-purple-50 transition-colors cursor-pointer">
                                <i class="fas fa-chart-pie text-3xl text-purple-500 mb-2"></i>
                                <h4 class="text-slate-700 font-bold text-sm">Analytics & Reports</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16">
            <h2 class="text-3xl font-black text-center mb-12 text-slate-700">Powerful Features</h2>
            <div class="flex flex-wrap -mx-3">
                <div class="w-full max-w-full px-3 mb-6 md:w-1/2 lg:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 hover:shadow-lg transition-shadow">
                        <div class="inline-block w-14 h-14 mb-4 text-center rounded-xl bg-gradient-to-tl from-purple-700 to-pink-500 flex items-center justify-center">
                            <i class="fas fa-fingerprint text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2 text-lg">Biometric Attendance</h4>
                        <p class="text-sm text-slate-500">Advanced attendance tracking with face recognition and GPS location verification.</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mb-6 md:w-1/2 lg:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 hover:shadow-lg transition-shadow">
                        <div class="inline-block w-14 h-14 mb-4 text-center rounded-xl bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center">
                            <i class="fas fa-users text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2 text-lg">Employee Management</h4>
                        <p class="text-sm text-slate-500">Complete employee profiles, departments, job titles, and organizational structure.</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mb-6 md:w-1/2 lg:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 hover:shadow-lg transition-shadow">
                        <div class="inline-block w-14 h-14 mb-4 text-center rounded-xl bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center">
                            <i class="fas fa-calendar-minus text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2 text-lg">Leave Management</h4>
                        <p class="text-sm text-slate-500">Streamlined leave requests with approval workflows and automatic leave balance tracking.</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mb-6 md:w-1/2 lg:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 hover:shadow-lg transition-shadow">
                        <div class="inline-block w-14 h-14 mb-4 text-center rounded-xl bg-gradient-to-tl from-yellow-600 to-orange-400 flex items-center justify-center">
                            <i class="fas fa-money-check text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2 text-lg">Payroll Processing</h4>
                        <p class="text-sm text-slate-500">Automated salary calculations, overtime pay, and comprehensive payroll reports.</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mb-6 md:w-1/2 lg:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 hover:shadow-lg transition-shadow">
                        <div class="inline-block w-14 h-14 mb-4 text-center rounded-xl bg-gradient-to-tl from-red-600 to-rose-400 flex items-center justify-center">
                            <i class="fas fa-file-invoice-dollar text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2 text-lg">Reimbursements</h4>
                        <p class="text-sm text-slate-500">Easy expense submission with approval workflow and tracking for all employee expenses.</p>
                    </div>
                </div>
                <div class="w-full max-w-full px-3 mb-6 md:w-1/2 lg:w-1/3">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 hover:shadow-lg transition-shadow">
                        <div class="inline-block w-14 h-14 mb-4 text-center rounded-xl bg-gradient-to-tl from-indigo-600 to-purple-400 flex items-center justify-center">
                            <i class="fas fa-chart-line text-2xl text-white"></i>
                        </div>
                        <h4 class="text-slate-700 font-bold mb-2 text-lg">Analytics & Reports</h4>
                        <p class="text-sm text-slate-500">Real-time insights and comprehensive reports on attendance, leaves, and payroll.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-16 bg-gradient-to-tl from-purple-700 to-pink-500 rounded-3xl p-12 text-center">
            <h2 class="text-3xl font-black text-white mb-4">Ready to Get Started?</h2>
            <p class="text-white/80 mb-8 text-lg">Join hundreds of companies using {{ config('app.name', 'ABS') }} to manage their workforce.</p>
            @guest
            <div class="flex justify-center gap-4">
                <a href="{{ route('register') }}" class="inline-block px-8 py-3 font-bold text-center text-purple-700 uppercase align-middle bg-white rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs leading-pro text-sm">
                    <i class="fas fa-rocket mr-2"></i> Start Free Trial
                </a>
                <a href="{{ route('login') }}" class="inline-block px-8 py-3 font-bold text-center text-white uppercase align-middle border border-white rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs leading-pro text-sm">
                    <i class="fas fa-play mr-2"></i> View Demo
                </a>
            </div>
            @else
            <a href="{{ url('/dashboard') }}" class="inline-block px-8 py-3 font-bold text-center text-purple-700 uppercase align-middle bg-white rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs leading-pro text-sm">
                <i class="fas fa-tachometer-alt mr-2"></i> Go to Dashboard
            </a>
            @endguest
        </div>
    </main>

    <footer class="w-full px-6 py-8 mx-auto mt-12">
        <div class="flex flex-wrap -mx-3 border-t border-gray-200 pt-8">
            <div class="w-full max-w-full px-3 mb-6 md:w-1/3">
                <h5 class="text-slate-700 font-bold mb-4">{{ config('app.name', 'ABS') }}</h5>
                <p class="text-sm text-slate-400">Modern attendance and employee management system for businesses of all sizes.</p>
            </div>
            <div class="w-full max-w-full px-3 mb-6 md:w-1/3">
                <h5 class="text-slate-700 font-bold mb-4">Quick Links</h5>
                <ul class="text-sm text-slate-400 space-y-2">
                    <li><a href="#" class="hover:text-purple-600">Features</a></li>
                    <li><a href="#" class="hover:text-purple-600">Pricing</a></li>
                    <li><a href="#" class="hover:text-purple-600">Documentation</a></li>
                    <li><a href="#" class="hover:text-purple-600">Support</a></li>
                </ul>
            </div>
            <div class="w-full max-w-full px-3 mb-6 md:w-1/3">
                <h5 class="text-slate-700 font-bold mb-4">Contact</h5>
                <ul class="text-sm text-slate-400 space-y-2">
                    <li><i class="fas fa-envelope mr-2"></i> support@abs-system.com</li>
                    <li><i class="fas fa-phone mr-2"></i> +1 (555) 123-4567</li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-8 pt-8 border-t border-gray-200">
            <p class="text-sm text-slate-400">
                © {{ date('Y') }} {{ config('app.name', 'ABS') }}. All rights reserved.
            </p>
        </div>
    </footer>

    <script src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js') }}"></script>
</body>
</html>
