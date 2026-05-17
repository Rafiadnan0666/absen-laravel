@extends('admin.dashboard.layout')

@section('title', 'Create Holiday - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="border-b-3 border-black pb-4 mb-4">
      <h6 class="text-xl font-bold">Create Holiday</h6>
    </div>
    <form action="{{ route('admin.holidays.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="nama_hari_libur" class="neo-label">Holiday Name</label>
        <input type="text" id="nama_hari_libur" name="nama_hari_libur" value="{{ old('nama_hari_libur') }}"
          class="neo-input" placeholder="Enter holiday name" required>
        @error('nama_hari_libur')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="mb-4">
        <label for="tanggal" class="neo-label">Date</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal') }}"
          class="neo-input" required>
        @error('tanggal')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="flex justify-end">
        <a href="{{ route('admin.holidays.index') }}" class="neo-btn-secondary mr-2">
          Cancel
        </a>
        <button type="submit" class="neo-btn-primary">
          Create
        </button>
      </div>
    </form>
  </div>
</div>
@endsection