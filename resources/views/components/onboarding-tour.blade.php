@if(session('show_tour') && auth()->user() && is_null(auth()->user()->onboarding_completed_at))
<div
    x-data="onboardingTour()"
    x-init="init()"
    x-show="step > 0"
    x-cloak
    class="fixed inset-0 z-[9999]"
    style="display: none;"
>
    <div class="absolute inset-0 bg-black/60" @click="skip()"></div>

    {{-- Step 1: Welcome --}}
    <div x-show="step === 1" x-transition:enter="animate-bounce-in" class="absolute inset-0 flex items-center justify-center">
        <div class="neo-card max-w-lg w-full mx-4 text-center animate-float" style="z-index: 10000;">
            <p class="text-6xl mb-4">👋</p>
            <h2 class="text-3xl font-black mb-2">WELCOME TO ABS!</h2>
            <p class="font-bold mb-6">Your Attendance Management System</p>
            <p class="text-sm mb-6">Let's take a quick tour to help you get started. It only takes 30 seconds!</p>
            <div class="flex justify-center gap-4">
                <button @click="skip()" class="neo-btn-secondary neo-btn-sm">SKIP TOUR</button>
                <button @click="next()" class="neo-btn-primary neo-btn-sm pulse-glow">LET'S GO! 🚀</button>
            </div>
        </div>
    </div>

    {{-- Step 2: Check-in/out --}}
    <div x-show="step === 2" x-transition:enter="animate-fade-in-up" class="absolute" style="z-index: 10000; top: 30%; left: 5%; max-width: 280px;">
        <div class="neo-card-yellow p-4 relative">
            <div class="absolute -top-3 -left-3 bg-neo-yellow border-3 border-black px-2 py-0 text-xs font-black rotate-[-5deg]">STEP 2/5</div>
            <p class="text-2xl mb-1">📍</p>
            <h3 class="font-black text-sm mb-1">CHECK IN / OUT</h3>
            <p class="text-xs font-bold">Tap here to check in with GPS verification. The system will validate your location against the office radius.</p>
            <button @click="next()" class="neo-btn-primary neo-btn-sm mt-2 text-xs pulse-glow">NEXT →</button>
        </div>
    </div>

    {{-- Step 3: Dashboard Stats --}}
    <div x-show="step === 3" x-transition:enter="animate-fade-in-up" class="absolute" style="z-index: 10000; top: 5%; right: 5%; max-width: 280px;">
        <div class="neo-card-pink p-4 relative">
            <div class="absolute -top-3 -right-3 bg-neo-pink border-3 border-black px-2 py-0 text-xs font-black rotate-[5deg]">STEP 3/5</div>
            <p class="text-2xl mb-1">📊</p>
            <h3 class="font-black text-sm mb-1">YOUR STATS</h3>
            <p class="text-xs font-bold">See your daily status, shift info, salary, and department at a glance.</p>
            <button @click="next()" class="neo-btn-primary neo-btn-sm mt-2 text-xs pulse-glow">NEXT →</button>
        </div>
    </div>

    {{-- Step 4: Charts & Graphs --}}
    <div x-show="step === 4" x-transition:enter="animate-fade-in-up" class="absolute" style="z-index: 10000; bottom: 10%; right: 5%; max-width: 280px;">
        <div class="neo-card-cyan p-4 relative">
            <div class="absolute -bottom-3 -right-3 bg-neo-cyan border-3 border-black px-2 py-0 text-xs font-black rotate-[-5deg]">STEP 4/5</div>
            <p class="text-2xl mb-1">📈</p>
            <h3 class="font-black text-sm mb-1">ANALYTICS</h3>
            <p class="text-xs font-bold">Track your weekly hours and monthly attendance rate with beautiful charts.</p>
            <button @click="next()" class="neo-btn-primary neo-btn-sm mt-2 text-xs pulse-glow">NEXT →</button>
        </div>
    </div>

    {{-- Step 5: Final --}}
    <div x-show="step === 5" x-transition:enter="animate-bounce-in" class="absolute inset-0 flex items-center justify-center">
        <div class="neo-card max-w-lg w-full mx-4 text-center" style="z-index: 10000;">
            <p class="text-6xl mb-4">🎉</p>
            <h2 class="text-3xl font-black mb-2">YOU'RE ALL SET!</h2>
            <p class="font-bold mb-6">Start by checking in for today!</p>
            <div class="flex justify-center gap-4">
                <button @click="complete()" class="neo-btn-primary neo-btn-sm pulse-glow">GET STARTED!</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function onboardingTour() {
    return {
        step: 1,
        init() {
            if (localStorage.getItem('onboarding_done') === 'true') {
                this.step = 0;
                return;
            }
            this.step = 1;
        },
        next() {
            if (this.step < 5) {
                this.step++;
            }
        },
        prev() {
            if (this.step > 1) {
                this.step--;
            }
        },
        async complete() {
            localStorage.setItem('onboarding_done', 'true');
            await fetch('{{ route("onboarding.complete") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            this.step = 0;
        },
        async skip() {
            localStorage.setItem('onboarding_done', 'true');
            await fetch('{{ route("onboarding.skip") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            });
            this.step = 0;
        }
    }
}
</script>
@endpush
@endif
