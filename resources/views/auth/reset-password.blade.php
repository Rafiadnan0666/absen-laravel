@extends('auth.layout')

@section('title', 'Reset Password - ABS')
@section('subtitle', 'Create a new password for your account')

@section('content')
<form method="POST" action="{{ route('password.store') }}">
@csrf

<input type="hidden" name="token" value="{{ $request->route('token') }}">

<div class="neo-form-group">
<label class="neo-label" for="email">Email</label>
<input type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus placeholder="email@example.com" class="neo-input">
@error('email')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="neo-form-group">
<label class="neo-label" for="password">New Password</label>
<input type="password" name="password" required autocomplete="new-password" placeholder="••••••••" class="neo-input">
@error('password')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="neo-form-group">
<label class="neo-label" for="password_confirmation">Confirm Password</label>
<input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" class="neo-input">
@error('password_confirmation')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<button type="submit" class="neo-btn-primary"><i class="fas fa-lock"></i> Reset Password</button>
</form>

@section('footer')
<p class="text-center">Back to <a href="{{ route('login') }}" class="neo-link"><strong>Sign in</strong></a></p>
@endsection
@endsection