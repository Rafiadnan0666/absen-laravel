@extends('admin.dashboard.layout')

@section('title', 'Create Shift - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">CREATE SHIFT</h6>
    </div>

    <form action="{{ route('admin.shifts.store') }}" method="POST">
      @csrf

      <div class="mb-4">
        <label for="nama_shift" class="neo-label">Shift Name</label>
        <input type="text" id="nama_shift" name="nama_shift" value="{{ old('nama_shift') }}" required
          class="neo-input"
          placeholder="Enter shift name" />
        @error('nama_shift')
          <p class="text-neo-red text-sm font-bold mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="jam_masuk" class="neo-label">Check In Time</label>
        <input type="time" id="jam_masuk" name="jam_masuk" value="{{ old('jam_masuk') }}" required
          class="neo-input" />
        @error('jam_masuk')
          <p class="text-neo-red text-sm font-bold mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="jam_pulang" class="neo-label">Check Out Time</label>
        <input type="time" id="jam_pulang" name="jam_pulang" value="{{ old('jam_pulang') }}" required
          class="neo-input" />
        @error('jam_pulang')
          <p class="text-neo-red text-sm font-bold mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-6">
        <label for="toleransi_telat_menit" class="neo-label">Late Tolerance (minutes)</label>
        <input type="number" id="toleransi_telat_menit" name="toleransi_telat_menit" value="{{ old('toleransi_telat_menit', 0) }}" required
          class="neo-input" />
        @error('toleransi_telat_menit')
          <p class="text-neo-red text-sm font-bold mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex gap-4">
        <button type="submit" class="neo-btn-primary">
          Save
        </button>
        <a href="{{ route('admin.shifts.index') }}" class="neo-btn-secondary">
          Cancel
        </a>
      </div>
    </form>
  </div>
</div>
@endsection