<x-guest-layout>
    <div class="neo-card max-w-md mx-auto mt-8">
        <h1 class="text-3xl font-black mb-4 text-center">VERIFY EMAIL</h1>
        <p class="mb-6 font-bold text-sm">Thanks for signing up! Please verify your email by clicking the link we sent.</p>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 border-2 border-green-500 p-2">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="neo-btn bg-blue-200">
                    {{ __('Resend Verification Email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="neo-btn bg-red-200">
                    {{ __('Log Out') }}
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
