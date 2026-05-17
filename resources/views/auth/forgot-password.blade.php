@extends('auth.layout')

@section('title', 'Forgot Password - ABS')
@section('subtitle', 'Enter your email to reset your password')

@section('content')
    <x-auth-session-status class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700" :status="session('status')" />

    <p class="text-sm text-slate-600 mb-6">Enter your email address and we'll send you a link to reset your password.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-6">
            <label for="email" class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="input-field"
                placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-500" />
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-paper-plane mr-2"></i>Send Reset Link
        </button>
    </form>

    @section('footer')
        <p class="text-center text-sm text-slate-600">
            Remember your password?
            <a href="{{ route('login') }}" class="font-semibold text-purple-600 hover:text-purple-800 hover:underline">
                Sign in
            </a>
        </p>
    @endsection
@endsection