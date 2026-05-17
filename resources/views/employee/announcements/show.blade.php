@extends('layouts.employee')

@section('page-title', 'Announcement')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="neo-section-title mb-0">Announcement</h1>
        <a href="{{ route('employee.announcements.index') }}" class="neo-btn-secondary">Back</a>
    </div>

    <div class="neo-card">
        <h2 class="text-3xl font-black mb-4">{{ $announcement->judul }}</h2>
        <p class="text-sm mb-6">
            Posted on {{ $announcement->created_at->format('d M Y H:i') }}
            by {{ $announcement->creator->nama_lengkap ?? 'Admin' }}
        </p>
        <div class="neo-input min-h-[150px] whitespace-pre-wrap">{{ $announcement->isi }}</div>
    </div>
@endsection