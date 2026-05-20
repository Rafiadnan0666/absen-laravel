<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'Admin Dashboard') - {{ config('app.name', 'ABS') }}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-mono min-h-screen bg-neo-bg">
    <aside class="neo-sidebar fixed h-full z-50 transition-transform -translate-x-full xl:translate-x-0 xl:left-0 overflow-y-auto">
        <div class="p-4 border-b-3 border-black">
            <a href="{{ route('admin.dashboard') }}" class="font-black text-xl block">
                <span class="text-neo-red">⚙️</span> ADMIN PANEL
            </a>
        </div>
        <nav class="py-2">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📊 DASHBOARD
            </a>
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                👥 USERS
            </a>
            <a href="{{ route('admin.departments.index') }}" class="{{ request()->routeIs('admin.departments.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                🏢 DEPARTMENTS
            </a>
            <a href="{{ route('admin.shifts.index') }}" class="{{ request()->routeIs('admin.shifts.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                ⏰ SHIFTS
            </a>
            <a href="{{ route('admin.locations.index') }}" class="{{ request()->routeIs('admin.locations.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📍 LOCATIONS
            </a>
            <a href="{{ route('admin.attendances.index') }}" class="{{ request()->routeIs('admin.attendances.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📅 ATTENDANCES
            </a>
            <a href="{{ route('admin.leaves.index') }}" class="{{ request()->routeIs('admin.leaves.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                🏖️ LEAVES
            </a>
            <a href="{{ route('admin.reimbursements.index') }}" class="{{ request()->routeIs('admin.reimbursements.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                💰 REIMBURSEMENTS
            </a>
            <a href="{{ route('admin.payrolls.index') }}" class="{{ request()->routeIs('admin.payrolls.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                💵 PAYROLLS
            </a>
            <a href="{{ route('admin.roles.index') }}" class="{{ request()->routeIs('admin.roles.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                🔐 ROLES
            </a>
            <a href="{{ route('admin.holidays.index') }}" class="{{ request()->routeIs('admin.holidays.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                🎉 HOLIDAYS
            </a>
            <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                ⚡ SETTINGS
            </a>
            <div class="my-4 border-t-3 border-black"></div>
            <a href="{{ route('hr.dashboard') }}" class="neo-sidebar-item">
                👥 HR PANEL
            </a>
            <a href="{{ route('employee.dashboard') }}" class="neo-sidebar-item">
                👷 EMPLOYEE PANEL
            </a>
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
                <a href="{{ route('hr.dashboard') }}" class="neo-btn-pink neo-btn-sm">
                    👥 HR PANEL
                </a>
                <a href="{{ route('employee.dashboard') }}" class="neo-btn-green neo-btn-sm">
                    👷 EMPLOYEE PANEL
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