@extends('auth.layout')

@section('title', 'Forgot Password - ABS')
@section('subtitle', 'Enter your email to reset your password')

@section('content')
@if(session('status'))<div class="neo-alert-success mb-4">{{ session('status') }}</div>@endif

<div class="neo-alert-info mb-4">Enter your email address and we'll send you a link to reset your password.</div>

<form method="POST" action="{{ route('password.email') }}">
@csrf

<div class="neo-form-group">
<label class="neo-label" for="email">Email</label>
<input type="email" name="email" value="{{ old('email') }}" required autofocus placeholder="email@example.com" class="neo-input">
@error('email')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<button type="submit" class="neo-btn-primary"><i class="fas fa-paper-plane"></i> Send Reset Link</button>
</form>

@section('footer')
<p class="text-center">Remember your password? <a href="{{ route('login') }}" class="neo-link"><strong>Sign in</strong></a></p>
@endsection
@endsection