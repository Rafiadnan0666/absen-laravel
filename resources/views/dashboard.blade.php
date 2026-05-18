<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-700 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-soft-xl sm:rounded-2xl p-8">
                <div class="flex items-center justify-between mb-8">
                    <div>
                        <h3 class="text-2xl font-bold text-slate-700">{{ __("You're logged in!") }}</h3>
                        <p class="text-slate-400">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }} · {{ auth()->user()->role ? auth()->user()->role->nama_role : 'No role' }}</p>
                    </div>
                </div>
                
                <!-- Mixed grid: row (full width) + columns side by side -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <!-- Quick Actions - spans 2 cols -->
                    <div class="lg:col-span-2 relative flex flex-col min-w-0 break-words bg-gradient-to-br from-purple-700 to-pink-500 shadow-soft-xl rounded-2xl bg-clip-border p-6">
                        <div class="flex-auto">
                            <div class="flex items-center justify-between mb-4">
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm text-white/80">Quick Actions</p>
                                <div class="w-12 h-12 text-center rounded-lg bg-white/20 flex items-center justify-center">
                                    <i class="fas fa-bolt text-lg text-white"></i>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-3">
                                @if(auth()->user()->hasRole('employee'))
                                    <a href="{{ route('employee.dashboard') }}" class="px-6 py-3 text-xs font-bold text-purple-700 uppercase bg-white rounded-lg hover:scale-102 transition-all shadow-lg">
                                        <i class="fas fa-user mr-1"></i> Employee Panel
                                    </a>
                                @endif
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                                    <a href="{{ route('admin.dashboard') }}" class="px-6 py-3 text-xs font-bold text-white uppercase bg-white/20 rounded-lg hover:bg-white/30 hover:scale-102 transition-all">
                                        <i class="fas fa-cog mr-1"></i> Admin Panel
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Account Info - 1 col -->
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 border border-slate-100">
                        <div class="flex-auto">
                            <div class="flex items-center justify-between mb-4">
                                <p class="mb-0 font-semibold text-sm text-slate-500">Account Info</p>
                                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center text-white text-sm">
                                    <i class="fas fa-user-circle"></i>
                                </div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                    <span class="text-xs text-slate-400">Name</span>
                                    <span class="text-sm font-semibold text-slate-700">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</span>
                                </div>
                                <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                    <span class="text-xs text-slate-400">Email</span>
                                    <span class="text-sm font-semibold text-slate-700">{{ auth()->user()->email }}</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <span class="text-xs text-slate-400">Role</span>
                                    <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl from-purple-700 to-pink-500">{{ auth()->user()->role ? auth()->user()->role->nama_role : 'No role' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- System Info + Today's Summary in 2-col row below -->
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <p class="mb-0 font-semibold text-sm text-slate-500">System Info</p>
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 flex items-center justify-center text-white text-sm">
                                <i class="fas fa-info-circle"></i>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                <span class="text-xs text-slate-400">Laravel</span>
                                <span class="text-sm font-semibold text-slate-700">{{ app()->version() }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-400">PHP</span>
                                <span class="text-sm font-semibold text-slate-700">{{ phpversion() }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 border border-slate-100">
                        <div class="flex items-center justify-between mb-4">
                            <p class="mb-0 font-semibold text-sm text-slate-500">Today's Summary</p>
                            <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-indigo-600 to-purple-500 flex items-center justify-center text-white text-sm">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                <span class="text-xs text-slate-400">Attendance</span>
                                <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl from-green-600 to-lime-400">Present</span>
                            </div>
                            <div class="flex justify-between items-center pb-2 border-b border-slate-100">
                                <span class="text-xs text-slate-400">Tasks</span>
                                <span class="text-sm font-semibold text-slate-700">3 Pending</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs text-slate-400">Meetings</span>
                                <span class="text-sm font-semibold text-slate-700">2 Today</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>