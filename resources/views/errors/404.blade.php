@extends('layouts.app')

@section('title', 'Page Not Found - ABS')

@section('content')
<div class="min-h-screen neo-section">
    <div class="max-w-2xl mx-auto px-4">
        <div class="neo-card text-center p-8">
            <div class="mb-6">
                <div class="neo-avatar bg-neo-red text-black text-3xl mx-auto">⚠️</div>
            </div>
            <h1 class="text-6xl font-black mb-4">404</h1>
            <p class="text-xl font-bold mb-6">Page Not Found</p>
            <p class="mb-8 font-bold">
                We couldn't find the page you're looking for.
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