@extends('profile.edit')

@section('content')
<section class="neo-card neo-section space-y-6">
    <header>
        <h2 class="neo-section-title">
            {{ __('Delete Account') }}
        </h2>

        <p class="mt-1 text-sm font-bold neo-alert-danger">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button"
        class="neo-btn-danger"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="neo-section-title">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p class="mt-1 text-sm font-bold">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6 neo-form-group">
                <neo-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <neo-input
                    id="password"
                    name="password"
                    type="password"
                    class="neo-input mt-1 block w-3/4"
                    placeholder="{{ __('Password') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')" class="neo-btn-secondary">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <button type="submit" class="neo-btn-danger ms-3">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
@endsection