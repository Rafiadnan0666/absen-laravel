<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Employee Panel') - {{ config('app.name', 'ABS') }}</title>

    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link href="{{ asset('assets/css/soft-ui-dashboard-tailwind.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="m-0 font-sans antialiased font-normal text-base leading-default bg-gray-50 text-slate-500">

    <aside class="max-w-62.5 ease-nav-brand z-990 fixed inset-y-0 my-4 ml-4 block w-full -translate-x-full flex-wrap items-center justify-between overflow-y-auto rounded-2xl border-0 bg-white p-0 antialiased shadow-none transition-transform duration-200 xl:left-0 xl:translate-x-0 xl:bg-transparent">
        <div class="h-19.5">
            <i class="absolute top-0 right-0 hidden p-4 opacity-50 cursor-pointer fas fa-times text-slate-400 xl:hidden" sidenav-close></i>
            <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap text-slate-700" href="{{ route('employee.dashboard') }}">
                <img src="{{ asset('assets/img/logo-ct.png') }}" class="inline h-full max-w-full transition-all duration-200 ease-nav-brand max-h-8" alt="main_logo" />
                <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Employee Panel</span>
            </a>
        </div>

        <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent" />

        <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
            <ul class="flex flex-col pl-0 mb-0">
                <li class="mt-0.5 w-full">
                    <a class="py-2.7 {{ request()->routeIs('employee.dashboard') ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white shadow-soft-2xl' : 'bg-white text-slate-700 shadow-soft-xl' }} text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors" href="{{ route('employee.dashboard') }}">
                        <span style="background: linear-gradient(to top left, #7c3aed, #db2777);" class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="fas fa-tachometer-alt text-white" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Dashboard</span>
                    </a>
                </li>

                <li class="mt-0.5 w-full">
                    <a class="py-2.7 {{ request()->routeIs('employee.attendances.*') ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white shadow-soft-2xl' : 'bg-white text-slate-700 shadow-soft-xl' }} text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors" href="{{ route('employee.attendances.index') }}">
                        <span style="background: linear-gradient(to top left, #7c3aed, #db2777);" class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="fas fa-calendar-check text-white" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Attendance</span>
                    </a>
                </li>

                <li class="mt-0.5 w-full">
                    <a class="py-2.7 {{ request()->routeIs('employee.leaves.*') ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white shadow-soft-2xl' : 'bg-white text-slate-700 shadow-soft-xl' }} text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors" href="{{ route('employee.leaves.index') }}">
                        <span style="background: linear-gradient(to top left, #7c3aed, #db2777);" class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="fas fa-calendar-times text-white" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Leaves</span>
                    </a>
                </li>

                <li class="mt-0.5 w-full">
                    <a class="py-2.7 {{ request()->routeIs('employee.reimbursements.*') ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white shadow-soft-2xl' : 'bg-white text-slate-700 shadow-soft-xl' }} text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors" href="{{ route('employee.reimbursements.index') }}">
                        <span style="background: linear-gradient(to top left, #7c3aed, #db2777);" class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="fas fa-file-invoice-dollar text-white" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Reimburse</span>
                    </a>
                </li>

                <li class="mt-0.5 w-full">
                    <a class="py-2.7 {{ request()->routeIs('employee.payrolls.*') ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white shadow-soft-2xl' : 'bg-white text-slate-700 shadow-soft-xl' }} text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors" href="{{ route('employee.payrolls.index') }}">
                        <span style="background: linear-gradient(to top left, #7c3aed, #db2777);" class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="fas fa-money-bill-wave text-white" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Payroll</span>
                    </a>
                </li>

                <li class="mt-0.5 w-full">
                    <a class="py-2.7 {{ request()->routeIs('employee.announcements.*') ? 'bg-gradient-to-tl from-purple-700 to-pink-500 text-white shadow-soft-2xl' : 'bg-white text-slate-700 shadow-soft-xl' }} text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold transition-colors" href="{{ route('employee.announcements.index') }}">
                        <span style="background: linear-gradient(to top left, #7c3aed, #db2777);" class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center">
                            <i class="fas fa-bullhorn text-white" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Announcements</span>
                    </a>
                </li>

                <li class="w-full mt-4">
                    <h6 class="pl-6 ml-2 font-bold leading-tight uppercase text-xs opacity-60">Account</h6>
                </li>

                <li class="mt-0.5 w-full">
                    <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors hover:bg-blue-500/10 rounded-lg" href="{{ route('profile.edit') }}">
                        <span class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center" style="background: #f1f5f9;">
                            <i class="fas fa-user text-slate-700" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Profile</span>
                    </a>
                </li>

                <li class="mt-0.5 w-full">
                    <a class="py-2.7 text-sm ease-nav-brand my-0 mx-4 flex items-center whitespace-nowrap px-4 transition-colors hover:bg-blue-500/10 rounded-lg" href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <span class="shadow-soft-2xl mr-2 flex h-8 w-8 items-center justify-center rounded-lg text-center" style="background: #f1f5f9;">
                            <i class="fas fa-sign-out-alt text-slate-700" style="font-size: 14px;"></i>
                        </span>
                        <span class="ml-1">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </aside>

    <main class="ease-soft-in-out xl:ml-68.5 relative h-full max-h-screen rounded-xl transition-all duration-200">
        <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all shadow-none duration-250 ease-soft-in rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="true">
            <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
                <nav>
                    <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
                        <li class="leading-normal text-sm">
                            <a class="opacity-50 text-slate-700" href="javascript:;">Pages</a>
                        </li>
                        <li class="text-sm pl-2 capitalize leading-normal text-slate-700 before:float-left before:pr-2 before:text-gray-600 before:content-['/']" aria-current="page">
                            @yield('page-title', 'Dashboard')
                        </li>
                    </ol>
                    <h6 class="mb-0 font-bold capitalize">@yield('page-title', 'Dashboard')</h6>
                </nav>

                <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
                    <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
                        <li class="flex items-center">
                            <a href="{{ route('employee.attendances.create') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft hover:bg-gray-100">
                                <i class="fas fa-fingerprint mr-1"></i> Check In/Out
                            </a>
                        </li>
                        <li class="flex items-center pl-4">
                            <a href="{{ route('profile.edit') }}" class="block px-0 py-2 font-semibold transition-all ease-nav-brand text-sm text-slate-500">
                                <i class="fa fa-user sm:mr-1"></i>
                                <span class="hidden sm:inline">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="w-full px-6 py-6 mx-auto">
            @yield('content')
        </div>
    </main>

    <script src="{{ asset('assets/js/soft-ui-dashboard-tailwind.js') }}"></script>
</body>
</html>
