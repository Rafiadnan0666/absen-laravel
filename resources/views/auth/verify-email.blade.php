@extends('auth.layout')

@section('title', 'Verify Email - ABS')
@section('subtitle', 'Verify your email address')

@section('content')
<div class="neo-alert-info mb-4">Thanks for signing up! Please verify your email by clicking the link we sent.</div>

@if(session('status') == 'verification-link-sent')
<div class="neo-alert-success mb-4">A new verification link has been sent to your email address.</div>
@endif

<div class="flex flex-col gap-3">
<form method="POST" action="{{ route('verification.send') }}">
@csrf
<button type="submit" class="neo-btn-primary"><i class="fas fa-paper-plane"></i> Resend Verification Email</button>
</form>

<form method="POST" action="{{ route('logout') }}">
@csrf
<button type="submit" class="neo-btn-secondary"><i class="fas fa-sign-out-alt"></i> Log Out</button>
</form>
</div>

@section('footer')
@endsection
@endsection