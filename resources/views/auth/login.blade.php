@extends('auth.layout')

@section('title', 'Login - ABS')

@section('header', 'Login to ABS')

@section('content')
    <x-auth-session-status class="mb-3" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="inline-block mb-1 text-xs font-bold text-slate-700">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Email">
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="mb-3">
            <label for="password" class="inline-block mb-1 text-xs font-bold text-slate-700">Password</label>
            <input id="password" type="password" name="password" required
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Password">
            <x-input-error :messages="$errors->get('password')" class="mt-1" />
        </div>

        <div class="flex items-center justify-between mt-2 mb-2">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="w-3.5 h-3.5 text-fuchsia-600 bg-gray-100 border-gray-300 rounded focus:ring-fuchsia-500" name="remember">
                <span class="ml-1.5 text-xs text-slate-700">Remember me</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-xs font-bold text-slate-700 hover:underline">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit" class="w-full inline-block px-4 py-2 text-xs font-bold uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
            Log in
        </button>
    </form>
@endsection
