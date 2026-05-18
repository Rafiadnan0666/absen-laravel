<div x-data>
    <!-- Modal Backdrop -->
    <div x-show="$store.profileModal.open" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto" 
         style="display: none;">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-50" aria-hidden="true" @click="$store.profileModal.closeModal()"></div>
            
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            
            <!-- Modal Panel -->
            <div x-show="$store.profileModal.open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                 class="relative inline-block w-full max-w-2xl p-6 my-8 text-left align-middle bg-white shadow-soft-xl rounded-2xl transition-all transform">
                
                <!-- Modal Header -->
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-slate-700">
                        <i class="fas fa-user-circle mr-2 text-purple-600"></i>
                        My Profile
                    </h3>
                    <button @click="$store.profileModal.closeModal()" class="text-slate-400 hover:text-slate-600 transition-colors">
                        <i class="fas fa-times text-xl"></i>
                    </button>
                </div>
                
                <!-- Modal Body -->
                <form method="post" action="{{ route('profile.update') }}">
                    @csrf
                    @method('patch')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Full Name</label>
                            <input type="text" name="nama_lengkap" value="{{ auth()->user()->nama_lengkap }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-purple-300 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ auth()->user()->email }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-purple-300 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Phone</label>
                            <input type="text" name="no_hp" value="{{ auth()->user()->no_hp ?? '' }}"
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-purple-300 focus:outline-none">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Join Date</label>
                            <input type="text" value="{{ auth()->user()->tanggal_masuk ? auth()->user()->tanggal_masuk->format('d M Y') : '-' }}" disabled
                                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-200 bg-gray-50 bg-clip-padding px-3 py-2 font-normal text-gray-500 outline-none">
                        </div>
                    </div>
                    
                    <div class="mb-6">
                        <label class="block text-xs font-bold text-slate-700 mb-1">Address</label>
                        <textarea name="alamat" rows="2"
                            class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-purple-300 focus:outline-none">{{ auth()->user()->alamat ?? '' }}</textarea>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 p-4 bg-gray-50 rounded-xl">
                        <div class="text-center">
                            <p class="text-xs text-slate-500 mb-1">Department</p>
                            <span class="text-sm font-bold text-slate-700">{{ auth()->user()->department?->nama_department ?? '-' }}</span>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-500 mb-1">Job Title</p>
                            <span class="text-sm font-bold text-slate-700">{{ auth()->user()->jobTitle?->nama_jabatan ?? '-' }}</span>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-500 mb-1">Role</p>
                            <span class="text-sm font-bold text-purple-600">{{ auth()->user()->role?->nama_role ?? '-' }}</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end gap-3">
                        <button type="button" @click="$store.profileModal.closeModal()" 
                            class="px-4 py-2 text-xs font-bold text-slate-700 uppercase bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="px-4 py-2 text-xs font-bold text-white uppercase bg-gradient-to-tl from-purple-700 to-pink-500 rounded-lg hover:scale-102 transition-all">
                            <i class="fas fa-save mr-1"></i> Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>