<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Employee Panel') - {{ config('app.name', 'ABS') }}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-mono min-h-screen bg-neo-bg">
    <aside class="neo-sidebar fixed h-full z-50 transition-transform -translate-x-full xl:translate-x-0 xl:left-0">
        <div class="p-4 border-b-3 border-black">
            <a href="{{ route('employee.dashboard') }}" class="font-black text-xl block">
                <span class="text-neo-purple">⚡</span> EMPLOYEE
            </a>
        </div>
        <nav class="py-2">
            <a href="{{ route('employee.dashboard') }}" class="{{ request()->routeIs('employee.dashboard') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📊 DASHBOARD
            </a>
            <a href="{{ route('employee.attendances.index') }}" class="{{ request()->routeIs('employee.attendances.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📅 ATTENDANCE
            </a>
            <a href="{{ route('employee.leaves.index') }}" class="{{ request()->routeIs('employee.leaves.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                🏖️ LEAVES
            </a>
            <a href="{{ route('employee.reimbursements.index') }}" class="{{ request()->routeIs('employee.reimbursements.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                💰 REIMBURSE
            </a>
            <a href="{{ route('employee.payrolls.index') }}" class="{{ request()->routeIs('employee.payrolls.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                💵 PAYROLL
            </a>
            <a href="{{ route('employee.announcements.index') }}" class="{{ request()->routeIs('employee.announcements.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📢 ANNOUNCEMENTS
            </a>
            <div class="my-4 border-t-3 border-black"></div>
            <a href="javascript:;" onclick="window.dispatchEvent(new CustomEvent('open-profile-modal'))" class="neo-sidebar-item">
                👤 PROFILE
            </a>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="neo-sidebar-item w-full text-left hover:bg-neo-red hover:text-black">
                    🚪 LOGOUT
                </button>
            </form>
        </nav>
    </aside>

    <main class="xl:ml-64 min-h-screen p-4">
        <nav class="neo-card mb-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <span class="font-black text-lg">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('employee.attendances.create') }}" class="neo-btn-primary neo-btn-sm">
                    ⏱️ CHECK IN/OUT
                </a>
                <button onclick="window.dispatchEvent(new CustomEvent('open-profile-modal'))" class="neo-btn-secondary neo-btn-sm">
                    👤 {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}
                </button>
            </div>
        </nav>

        <div class="space-y-6">
            @yield('content')
        </div>
    </main>

    @include('components.profile-modal')
    @include('components.onboarding-tour')
    @include('components.scroll-to-top')
    @stack('scripts')
</body>
</html>