@extends('profile.edit')

@section('content')
<section class="neo-card neo-section">
    <header>
        <h2 class="neo-section-title">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm font-bold">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 neo-form-group space-y-6">
        @csrf
        @method('patch')

        <div class="neo-form-group">
            <neo-label for="name" :value="__('Name')" />
            <neo-input id="name" name="name" type="text" class="neo-input mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div class="neo-form-group">
            <neo-label for="email" :value="__('Email')" />
            <neo-input id="email" name="email" type="email" class="neo-input mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 font-bold">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="neo-btn-sm neo-btn-secondary">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm neo-alert-success">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="neo-btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm font-bold neo-alert-success"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
@endsection