@extends('admin.dashboard.layout')

@section('title', 'Create Department - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">Create Department</h6>
    </div>
    <form action="{{ route('admin.departments.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="nama_department" class="neo-label">Department Name</label>
        <input type="text" id="nama_department" name="nama_department" value="{{ old('nama_department') }}" required
          class="neo-input" placeholder="Enter department name" />
        @error('nama_department')
          <p class="text-neo-red text-sm font-bold mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label for="deskripsi" class="neo-label">Description</label>
        <textarea id="deskripsi" name="deskripsi" rows="4"
          class="neo-input" placeholder="Enter description">{{ old('deskripsi') }}</textarea>
        @error('deskripsi')
          <p class="text-neo-red text-sm font-bold mt-1">{{ $message }}</p>
        @enderror
      </div>
      <div class="flex gap-4">
        <button type="submit" class="neo-btn-primary">
          Save
        </button>
        <a href="{{ route('admin.departments.index') }}" class="neo-btn-secondary">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection