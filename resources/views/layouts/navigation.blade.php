<nav class="neo-card mb-4">
    <div class="flex justify-between items-center">
        <div class="flex items-center gap-8">
            <a href="{{ route('dashboard') }}" class="font-black text-xl">
                <span class="text-neo-purple">⚡</span> {{ config('app.name', 'ABS') }}
            </a>
            <div class="hidden sm:flex gap-2">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'neo-btn-primary neo-btn-sm' : 'neo-btn-secondary neo-btn-sm' }}">
                    📊 Dashboard
                </a>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="neo-btn-secondary neo-btn-sm flex items-center gap-2">
                    <span>{{ Auth::user()->nama_lengkap ?? Auth::user()->name }}</span>
                    <span>▼</span>
                </button>
                <div x-show="open" @click.away="open = false" class="neo-dropdown right-0">
                    <a href="{{ route('profile.edit') }}" class="neo-dropdown-item">👤 Profile</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="neo-dropdown-item w-full text-left hover:bg-neo-red hover:text-black">
                            🚪 Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</nav>