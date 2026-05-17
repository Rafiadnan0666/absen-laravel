@extends('auth.layout')

@section('title', 'Login - ABS')
@section('subtitle', 'Sign in')

@section('content')
@if(session('status'))<div class="status">{{ session('status') }}</div>@endif

<form method="POST" action="{{ route('login') }}">
@csrf
<label>Email</label>
<input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email">
@error('email')<div class="error">{{ $message }}</div>@enderror

<label>Password</label>
<input type="password" name="password" required placeholder="••••••">
@error('password')<div class="error">{{ $message }}</div>@enderror

<div class="flex" style="margin-bottom:12px;">
<label style="font-weight:400;"><input type="checkbox" name="remember" class="checkbox">Remember</label>
@if(Route::has('password.request'))<a href="{{ route('password.request') }}">Forgot?</a>@endif
</div>

<button type="submit" class="btn"><i class="fas fa-sign-in-alt"></i> Sign In</button>
</form>

@section('footer')
<p>No account? <a href="{{ route('register') }}">Sign up</a></p>
@endsection
@endsection