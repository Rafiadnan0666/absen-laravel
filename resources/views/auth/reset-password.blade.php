@extends('auth.layout')

@section('title', 'Reset Password - ABS')
@section('subtitle', 'Create a new password for your account')

@section('content')
    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input id="email" type="email" name="email" :value="old('email', $request->email)" required autofocus
                class="input-field"
                placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">New Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="input-field"
                placeholder="Enter new password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
        </div>

        <div class="mb-6">
            <label for="password_confirmation" class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="input-field"
                placeholder="Confirm new password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-sm text-red-500" />
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-lock mr-2"></i>Reset Password
        </button>
    </form>

    @section('footer')
        <p class="text-center text-sm text-slate-600">
            Back to
            <a href="{{ route('login') }}" class="font-semibold text-purple-600 hover:text-purple-800 hover:underline">
                Sign in
            </a>
        </p>
    @endsection
@endsection