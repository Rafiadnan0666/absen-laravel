<div class="flex flex-col sm:flex-row gap-3 mb-4 px-6 pt-4" x-data>
    <div class="relative flex-1">
        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
        <input type="text" x-model="$root.closest('[x-data]').search ?? $root.closest('[x-data]').searchValue ?? ''" 
               placeholder="{{ $placeholder ?? 'Search...' }}" 
               class="w-full pl-8 pr-4 py-2 text-sm border border-slate-200 rounded-lg focus:border-purple-400 focus:ring-1 focus:ring-purple-400 outline-none transition-all bg-white">
    </div>
    @if(isset($filters))
        {{ $filters }}
    @endif
</div>