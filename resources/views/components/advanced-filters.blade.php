<div class="neo-card p-4 mb-6 fade-in-up" x-data="{ open: false }">
    <button @click="open = !open" class="w-full flex items-center justify-between font-black text-sm uppercase">
        <span>🔍 Advanced Filters</span>
        <span x-show="!open" class="text-lg">▼</span>
        <span x-show="open" class="text-lg">▲</span>
    </button>

    <form x-show="open" x-transition:enter="fade-in-up" method="GET" action="{{ $action }}" class="mt-4 space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-{{ min(6, count($filters)) }} gap-3">
            @foreach($filters as $key => $filter)
                @if($filter['type'] === 'text')
                <div>
                    <label class="neo-label text-xs">{{ $filter['label'] }}</label>
                    <input type="text" name="{{ $key }}" value="{{ request($key) }}"
                        class="neo-input w-full"
                        placeholder="{{ $filter['placeholder'] ?? '' }}">
                </div>
                @elseif($filter['type'] === 'date')
                <div>
                    <label class="neo-label text-xs">{{ $filter['label'] }}</label>
                    <input type="date" name="{{ $key }}" value="{{ request($key) }}"
                        class="neo-input w-full">
                </div>
                @elseif($filter['type'] === 'select')
                <div>
                    <label class="neo-label text-xs">{{ $filter['label'] }}</label>
                    <select name="{{ $key }}" class="neo-input w-full">
                        <option value="">All</option>
                        @foreach($filter['options'] as $val => $label)
                            <option value="{{ $val }}" {{ request($key) == $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                @elseif($filter['type'] === 'month')
                <div>
                    <label class="neo-label text-xs">{{ $filter['label'] }}</label>
                    <select name="{{ $key }}" class="neo-input w-full">
                        <option value="">All</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ request($key) == $m ? 'selected' : '' }}>
                                {{ \Carbon\Carbon::create(null, $m)->format('F') }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif
            @endforeach
        </div>

        <div class="flex gap-2 pt-2">
            <button type="submit" class="neo-btn-primary neo-btn-sm pulse-glow">FILTER</button>
            <a href="{{ $action }}" class="neo-btn-secondary neo-btn-sm">RESET</a>
        </div>
    </form>
</div>
