<x-guest-layout>
    <div class="neo-card max-w-md mx-auto mt-8">
        <h1 class="text-3xl font-black mb-4 text-center">CONFIRM PASSWORD</h1>
        <p class="mb-6 font-bold text-sm">This is a secure area. Please confirm your password before continuing.</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <!-- Password -->
            <div class="mb-6">
                <label for="password" class="block text-lg font-black mb-2">PASSWORD</label>
                <x-text-input id="password" class="neo-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="flex justify-end">
                <button type="submit" class="neo-btn bg-green-200">
                    {{ __('Confirm') }}
                </button>
            </div>
        </form>
    </div>
</x-guest-layout>
