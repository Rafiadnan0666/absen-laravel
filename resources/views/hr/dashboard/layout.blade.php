<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'HR Dashboard') - {{ config('app.name', 'ABS') }}</title>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-mono min-h-screen">
    <aside class="neo-sidebar fixed h-full z-50 transition-transform -translate-x-full xl:translate-x-0 xl:left-0">
        <div class="p-4 border-b-3 border-black">
            <a href="{{ route('hr.dashboard') }}" class="font-black text-xl block">
                <span class="text-neo-pink">👥</span> HR PANEL
            </a>
        </div>
        <nav class="py-2">
            <a href="{{ route('hr.dashboard') }}" class="{{ request()->routeIs('hr.dashboard') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📊 DASHBOARD
            </a>
            <a href="{{ route('hr.attendances.index') }}" class="{{ request()->routeIs('hr.attendances.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                📅 ATTENDANCE
            </a>
            <a href="{{ route('hr.leaves.index') }}" class="{{ request()->routeIs('hr.leaves.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                🏖️ LEAVES
            </a>
            <a href="{{ route('hr.payrolls.index') }}" class="{{ request()->routeIs('hr.payrolls.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                💵 PAYROLLS
            </a>
            <a href="{{ route('hr.reimbursements.index') }}" class="{{ request()->routeIs('hr.reimbursements.*') ? 'neo-sidebar-item-active' : 'neo-sidebar-item' }}">
                💰 REIMBURSEMENTS
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
        <nav class="neo-card mb-4 flex justify-between items-center rounded-none">
            <div class="flex items-center gap-4">
                <span class="font-black text-lg">@yield('page-title', 'Dashboard')</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('employee.dashboard') }}" class="neo-btn-green neo-btn-sm">
                    👷 EMPLOYEE PANEL
                </a>
                <a href="{{ route('admin.dashboard') }}" class="neo-btn-purple neo-btn-sm">
                    ⚙️ ADMIN PANEL
                </a>
                <button onclick="window.dispatchEvent(new CustomEvent('open-profile-modal'))" class="neo-btn-secondary neo-btn-sm">
                    👤 {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}
                </button>
            </div>
        </nav>

        <div class="neo-card rounded-none">
            @yield('content')
        </div>
    </main>

    @include('components.profile-modal')
</body>
</html>