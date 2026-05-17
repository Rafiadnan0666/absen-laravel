<div x-data="{ 
    open: false,
    init() {
        window.addEventListener('open-profile-modal', () => this.open = true);
        window.addEventListener('close-profile-modal', () => this.open = false);
    }
}">
    <template x-if="open">
        <div class="fixed inset-0 z-[9999] overflow-y-auto" x-show="open">
            <div class="fixed inset-0 bg-black/60" @click="open = false" x-show="open"></div>
            
            <div class="flex min-h-full items-center justify-center p-4">
                <div class="neo-modal-content w-full max-w-lg" x-show="open"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="opacity-100 scale-100"
                    x-transition:leave-end="opacity-0 scale-95">
                    
                    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
                        <div class="flex items-center gap-4">
                            <div class="neo-avatar bg-neo-purple text-black text-xl">👤</div>
                            <div>
                                <h3 class="text-xl font-black">MY PROFILE</h3>
                                <p class="text-sm font-bold">Update your information</p>
                            </div>
                        </div>
                        <button @click="open = false" class="neo-btn-secondary neo-btn-sm">✕</button>
                    </div>
                    
                    <form method="post" action="{{ route('profile.update') }}">
                        @csrf
                        @method('patch')
                        
                        <div class="space-y-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div class="neo-form-group">
                                    <label class="neo-label">FULL NAME</label>
                                    <input type="text" name="nama_lengkap" value="{{ auth()->user()->nama_lengkap }}" class="neo-input">
                                </div>
                                <div class="neo-form-group">
                                    <label class="neo-label">EMAIL</label>
                                    <input type="email" name="email" value="{{ auth()->user()->email }}" class="neo-input">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div class="neo-form-group">
                                    <label class="neo-label">PHONE</label>
                                    <input type="text" name="no_hp" value="{{ auth()->user()->no_hp ?? '' }}" class="neo-input">
                                </div>
                                <div class="neo-form-group">
                                    <label class="neo-label">JOIN DATE</label>
                                    <input type="text" value="{{ auth()->user()->tanggal_masuk ? auth()->user()->tanggal_masuk->format('d M Y') : '-' }}" disabled class="neo-input bg-[#f0f0f0]">
                                </div>
                            </div>
                            
                            <div class="neo-form-group">
                                <label class="neo-label">ADDRESS</label>
                                <textarea name="alamat" rows="2" class="neo-input">{{ auth()->user()->alamat ?? '' }}</textarea>
                            </div>
                            
                            <div class="grid grid-cols-3 gap-2 p-4 border-3 border-black bg-neo-yellow">
                                <div class="text-center">
                                    <p class="text-sm font-bold uppercase">Department</p>
                                    <p class="text-sm font-black">{{ auth()->user()->department->nama_department ?? '-' }}</p>
                                </div>
                                <div class="text-center border-l-3 border-black">
                                    <p class="text-sm font-bold uppercase">Job Title</p>
                                    <p class="text-sm font-black">{{ auth()->user()->jobTitle->nama_jabatan ?? '-' }}</p>
                                </div>
                                <div class="text-center border-l-3 border-black">
                                    <p class="text-sm font-bold uppercase">Role</p>
                                    <p class="text-sm font-black text-neo-purple">{{ auth()->user()->role->nama_role ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end gap-3 mt-6 pt-4 border-t-3 border-black">
                            <button type="button" @click="open = false" class="neo-btn-secondary">CANCEL</button>
                            <button type="submit" class="neo-btn-primary">💾 SAVE CHANGES</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </template>
</div>