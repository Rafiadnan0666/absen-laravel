@extends('auth.layout')

@section('title', 'Login - ABS')
@section('subtitle', 'Sign in')

@section('content')
@if(session('status'))<div class="neo-alert-success mb-4">{{ session('status') }}</div>@endif

<form method="POST" action="{{ route('login') }}">
@csrf

<div class="neo-form-group">
<label for="email" class="neo-label">Email</label>
<input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus placeholder="email@example.com" class="neo-input">
@error('email')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="neo-form-group">
<label for="password" class="neo-label">Password</label>
<input type="password" name="password" id="password" required placeholder="••••••••" class="neo-input">
@error('password')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="flex items-center justify-between mb-4">
<label style="display: flex; align-items: center; gap: 0.5rem; font-weight: normal;">
<input type="checkbox" name="remember" class="neo-checkbox">Remember
</label>
@if(Route::has('password.request'))<a href="{{ route('password.request') }}" class="neo-link">Forgot?</a>@endif
</div>

<button type="submit" class="neo-btn-primary w-full"><i class="fas fa-sign-in-alt"></i> Sign In</button>
</form>

@section('footer')
<p class="text-center">No account? <a href="{{ route('register') }}" class="neo-link"><strong>Sign up</strong></a></p>
@endsection
@endsection