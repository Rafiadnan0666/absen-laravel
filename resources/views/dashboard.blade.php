<x-app-layout>
    <x-slot name="header">
        <h2 class="neo-section-title">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="neo-section">
                <div class="neo-card mb-6">
                    <p class="font-bold text-lg">You're logged in!</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="neo-card-yellow">
                        <div class="flex justify-between items-start mb-4">
                            <p class="font-bold text-sm">⚡ QUICK ACTIONS</p>
                            <div class="neo-avatar bg-neo-purple text-black">⚡</div>
                        </div>
                        <div class="space-y-3">
                            @if(auth()->user()->hasRole('employee'))
                                <a href="{{ route('employee.dashboard') }}" class="neo-btn-primary neo-btn-sm block text-center">
                                    👤 EMPLOYEE PANEL
                                </a>
                            @endif
                            @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                                <a href="{{ route('admin.dashboard') }}" class="neo-btn-purple neo-btn-sm block text-center">
                                    ⚙️ ADMIN PANEL
                                </a>
                            @endif
                        </div>
                    </div>

                    <div class="neo-card-cyan">
                        <div class="flex justify-between items-start mb-4">
                            <p class="font-bold text-sm">👤 ACCOUNT INFO</p>
                            <div class="neo-avatar bg-neo-orange text-black">👤</div>
                        </div>
                        <div class="space-y-2 text-sm">
                            <p><strong>Name:</strong> {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</p>
                            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
                            <p><strong>Role:</strong> {{ auth()->user()->role ? auth()->user()->role->nama_role : 'No role' }}</p>
                        </div>
                    </div>

                    <div class="neo-card-pink">
                        <div class="flex justify-between items-start mb-4">
                            <p class="font-bold text-sm text-black">ℹ️ SYSTEM INFO</p>
                            <div class="neo-avatar bg-white text-black">ℹ️</div>
                        </div>
                        <div class="space-y-2 text-sm text-black">
                            <p><strong>Laravel:</strong> {{ app()->version() }}</p>
                            <p><strong>PHP:</strong> {{ phpversion() }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>