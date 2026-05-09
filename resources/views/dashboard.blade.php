<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-700 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-soft-xl sm:rounded-2xl p-8">
                <div class="text-slate-900">
                    {{ __("You're logged in!") }}
                </div>
                
                <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6">
                        <div class="flex-auto">
                            <div class="flex flex-row -mx-3">
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">Quick Actions</p>
                                </div>
                                <div class="px-3 text-right basis-1/3">
                                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500">
                                        <i class="fas fa-bolt text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4 space-y-3">
                                @if(auth()->user()->hasRole('employee'))
                                    <a href="{{ route('employee.dashboard') }}" class="inline-block px-6 py-2 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all">
                                        <i class="fas fa-user mr-1"></i> Employee Panel
                                    </a>
                                @endif
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('hr'))
                                    <a href="{{ route('admin.dashboard') }}" class="inline-block px-6 py-2 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 transition-all ml-2">
                                        <i class="fas fa-cog mr-1"></i> Admin Panel
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6">
                        <div class="flex-auto">
                            <div class="flex flex-row -mx-3">
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">Account Info</p>
                                </div>
                                <div class="px-3 text-right basis-1/3">
                                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                        <i class="fas fa-user-circle text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-slate-700"><strong>Name:</strong> {{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</p>
                                <p class="text-sm text-slate-700"><strong>Email:</strong> {{ auth()->user()->email }}</p>
                                <p class="text-sm text-slate-700"><strong>Role:</strong> {{ auth()->user()->role ? auth()->user()->role->nama_role : 'No role' }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6">
                        <div class="flex-auto">
                            <div class="flex flex-row -mx-3">
                                <div class="flex-none w-2/3 max-w-full px-3">
                                    <p class="mb-0 font-sans font-semibold leading-normal text-sm text-slate-500">System Info</p>
                                </div>
                                <div class="px-3 text-right basis-1/3">
                                    <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-600 to-rose-400">
                                        <i class="fas fa-info-circle text-lg relative top-3.5 text-white"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-4">
                                <p class="text-sm text-slate-700"><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                                <p class="text-sm text-slate-700"><strong>PHP Version:</strong> {{ phpversion() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
