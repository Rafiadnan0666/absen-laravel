<x-app-layout>
    <x-slot name="header">
        <h2 class="neo-section-title">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="neo-section">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="neo-card">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="neo-card-yellow">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="neo-card-pink">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>