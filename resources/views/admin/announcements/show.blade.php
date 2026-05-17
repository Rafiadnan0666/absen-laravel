@extends('admin.dashboard.layout')

@section('title', 'View Announcement - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="border-b-3 border-black pb-4 mb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">Announcement Details</h6>
        <a href="{{ route('admin.announcements.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
      </div>
    </div>
    <div class="mb-4">
      <label class="neo-label">Title</label>
      <p class="text-sm">{{ $announcement->judul }}</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">Content</label>
      <p class="text-sm whitespace-pre-wrap">{{ $announcement->isi }}</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">Created By</label>
      <p class="text-sm">{{ $announcement->creator->name ?? 'N/A' }}</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">Created At</label>
      <p class="text-sm">{{ $announcement->created_at->format('d M Y H:i') }}</p>
    </div>
    <div class="flex justify-end mt-6">
      <a href="{{ route('admin.announcements.edit', $announcement) }}" class="neo-btn-secondary mr-2">
        <i class="fas fa-edit mr-1"></i> Edit
      </a>
      <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Delete this announcement?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="neo-btn-danger">
          <i class="fas fa-trash mr-1"></i> Delete
        </button>
      </form>
    </div>
  </div>
</div>
@endsection