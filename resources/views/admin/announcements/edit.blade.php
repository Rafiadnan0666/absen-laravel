@extends('admin.dashboard.layout')

@section('title', 'Edit Announcement - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="border-b-3 border-black pb-4 mb-4">
      <h6 class="text-xl font-bold">Edit Announcement</h6>
    </div>
    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="judul" class="neo-label">Title</label>
        <input type="text" id="judul" name="judul" value="{{ old('judul', $announcement->judul) }}"
          class="neo-input" placeholder="Enter announcement title" required>
        @error('judul')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label for="isi" class="neo-label">Content</label>
        <textarea id="isi" name="isi" rows="6" class="neo-input"
          placeholder="Enter announcement content" required>{{ old('isi', $announcement->isi) }}</textarea>
        @error('isi')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="flex justify-end">
        <a href="{{ route('admin.announcements.index') }}" class="neo-btn-secondary mr-2">
          Cancel
        </a>
        <button type="submit" class="neo-btn-primary">
          Update
        </button>
      </div>
    </form>
  </div>
</div>
@endsection