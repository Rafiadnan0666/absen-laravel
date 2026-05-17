@extends('auth.layout')

@section('title', 'Confirm Password - ABS')
@section('subtitle', 'Please confirm your password to continue')

@section('content')
<div class="neo-alert-info mb-4">This is a secure area. Please confirm your password before continuing.</div>

<form method="POST" action="{{ route('password.confirm') }}">
@csrf

<div class="neo-form-group">
<label class="neo-label" for="password">Password</label>
<input type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="neo-input">
@error('password')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<button type="submit" class="neo-btn-primary"><i class="fas fa-check"></i> Confirm</button>
</form>

@section('footer')
<form method="POST" action="{{ route('logout') }}" class="text-center">
@csrf
<button type="submit" class="neo-btn-secondary"><i class="fas fa-sign-out-alt"></i> Sign out</button>
</form>
@endsection
@endsection