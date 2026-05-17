@extends('admin.dashboard.layout')

@section('title', 'Edit Job Title - Admin')

@section('content')
<div class="space-y-6">
  <div>
    <div class="neo-card">
      <div class="mb-4 border-b-3 border-black pb-4">
        <h6 class="text-xl font-bold">Edit Job Title</h6>
      </div>
      <div>
        <form action="{{ route('admin.job-titles.update', $jobTitle) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="nama_jabatan" class="neo-label">Job Title Name</label>
            <input type="text" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan', $jobTitle->nama_jabatan) }}" required
              class="neo-input" />
            @error('nama_jabatan')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="deskripsi" class="neo-label">Description</label>
            <textarea id="deskripsi" name="deskripsi" rows="3"
              class="neo-input">{{ old('deskripsi', $jobTitle->deskripsi) }}</textarea>
            @error('deskripsi')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="default_gaji" class="neo-label">Default Salary</label>
            <input type="number" id="default_gaji" name="default_gaji" value="{{ old('default_gaji', $jobTitle->default_gaji) }}" step="0.01"
              class="neo-input" />
            @error('default_gaji')
              <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex gap-4">
            <button type="submit" class="neo-btn-primary">
              Update
            </button>
            <a href="{{ route('admin.job-titles.index') }}" class="neo-btn-secondary">
              Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection