@extends('layouts.app')

@section('title', 'Access Forbidden - ABS')

@section('content')
<div class="min-h-screen neo-section">
    <div class="max-w-2xl mx-auto px-4">
        <div class="neo-card-yellow text-center p-8">
            <div class="mb-6">
                <div class="neo-avatar bg-neo-orange text-black text-3xl mx-auto">🔒</div>
            </div>
            <h1 class="text-6xl font-black mb-4">403</h1>
            <p class="text-xl font-bold mb-6">Access Forbidden</p>
            <p class="mb-8 font-bold">
                You don't have permission to access this resource.
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