@extends('layouts.employee')

@section('page-title', 'Announcements')

@section('content')
    <h1 class="neo-section-title">Announcements</h1>

    <div class="space-y-6">
        @forelse($announcements as $announcement)
            <div class="neo-card">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-2xl font-black">{{ $announcement->judul }}</h3>
                    <span class="text-sm">{{ $announcement->created_at->format('d M Y H:i') }}</span>
                </div>
                <div class="neo-input min-h-[80px] mb-4 whitespace-pre-wrap">{!! nl2br(e($announcement->isi)) !!}</div>
                <div class="flex justify-between items-center">
                    <p class="text-sm">By: {{ $announcement->creator->nama_lengkap ?? 'Admin' }}</p>
                    <a href="{{ route('employee.announcements.show', $announcement) }}" class="neo-btn-secondary">Read More</a>
                </div>
            </div>
        @empty
            <div class="neo-card">
                <p class="font-bold py-4 text-center">No announcements yet</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $announcements->links('vendor.pagination.neo') }}
    </div>
@endsection