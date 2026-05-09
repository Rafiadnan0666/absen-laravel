@extends('layouts.guest')

@section('title', 'Forgot Password - ABS')

@section('header', 'Forgot Password')

@section('content')
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <p class="mb-6 text-sm text-slate-500 text-center">Enter your email and we'll send a password reset link.</p>

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <label for="email" class="inline-block mb-2 text-sm font-bold text-slate-700">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:underline">
                {{ __('Back to login') }}
            </a>

            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
                {{ __('Send Reset Link') }}
            </button>
        </div>
    </form>
@endsection
