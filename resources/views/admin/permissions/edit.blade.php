@extends('admin.dashboard.layout')

@section('title', 'Edit Permission - Admin')

@section('content')
<div class="space-y-6">
  <div>
    <div class="neo-card">
      <div class="mb-6 border-b-3 border-black pb-4">
        <h6 class="neo-section-title">EDIT PERMISSION</h6>
      </div>
      <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="neo-form-group">
          <label for="nama_permission" class="neo-label">Permission Name</label>
          <input type="text" id="nama_permission" name="nama_permission" value="{{ old('nama_permission', $permission->nama_permission) }}" required class="neo-input">
          @error('nama_permission')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="flex gap-4">
          <button type="submit" class="neo-btn-primary">Update</button>
          <a href="{{ route('admin.permissions.index') }}" class="neo-btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection