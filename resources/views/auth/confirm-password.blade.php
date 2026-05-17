@extends('auth.layout')

@section('title', 'Confirm Password - ABS')
@section('subtitle', 'Please confirm your password to continue')

@section('content')
    <p class="text-sm text-slate-600 mb-6">This is a secure area. Please confirm your password before continuing.</p>

    <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <div class="mb-6">
            <label for="password" class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                class="input-field"
                placeholder="Enter your password">
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-500" />
        </div>

        <button type="submit" class="btn-primary">
            <i class="fas fa-check mr-2"></i>Confirm
        </button>
    </form>

    @section('footer')
        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-sm font-medium text-slate-500 hover:text-slate-700">
                <i class="fas fa-sign-out-alt mr-1"></i>Sign out
            </button>
        </form>
    @endsection
@endsection