@extends('layouts.app')

@section('title', 'Server Error - ABS')

@section('content')
<div class="min-h-screen neo-section">
    <div class="max-w-2xl mx-auto px-4">
        <div class="neo-card-red text-center p-8">
            <div class="mb-6">
                <div class="neo-avatar bg-white text-black text-3xl mx-auto">💥</div>
            </div>
            <h1 class="text-6xl font-black mb-4">500</h1>
            <p class="text-xl font-bold mb-6">Server Error</p>
            <p class="mb-8 font-bold">
                Something went wrong on our end. Please try again later.
            </p>
            <div class="space-x-4">
                <a href="{{ url('/') }}" class="neo-btn-primary">
                    🏠 GO TO HOMEPAGE
                </a>
                <a href="javascript:history.back()" class="neo-btn-secondary">
                    ⬅️ GO BACK
                </a>
            </div>
        </div>
    </div>
</div>
@endsection