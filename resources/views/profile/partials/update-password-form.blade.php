<section class="neo-card neo-section">
    <header>
        <h2 class="neo-section-title">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm font-bold">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 neo-form-group space-y-6">
        @csrf
        @method('put')

        <div class="neo-form-group">
            <x-neo-label for="update_password_current_password">{{ __('Current Password') }}</x-neo-label>
            <x-neo-input id="update_password_current_password" name="current_password" type="password" class="neo-input mt-1 block w-full" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div class="neo-form-group">
            <x-neo-label for="update_password_password">{{ __('New Password') }}</x-neo-label>
            <x-neo-input id="update_password_password" name="password" type="password" class="neo-input mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div class="neo-form-group">
            <x-neo-label for="update_password_password_confirmation">{{ __('Confirm Password') }}</x-neo-label>
            <x-neo-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="neo-input mt-1 block w-full" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="neo-btn-primary">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
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
