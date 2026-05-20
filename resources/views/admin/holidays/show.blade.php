@extends('admin.dashboard.layout')

@section('title', 'View Holiday - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="border-b-3 border-black pb-4 mb-4">
      <div class="flex justify-between items-center">
        <h6 class="neo-section-title">HOLIDAY DETAILS</h6>
        <a href="{{ route('admin.holidays.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
      </div>
    </div>
    <div class="mb-4">
      <label class="neo-label">Holiday Name</label>
      <p>{{ $holiday->nama_hari_libur }}</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">Date</label>
      <p>{{ $holiday->tanggal->format('d M Y') }}</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">Day</label>
      <p>{{ $holiday->tanggal->format('l') }}</p>
    </div>
    <div class="flex justify-end mt-6">
      <a href="{{ route('admin.holidays.edit', $holiday) }}" class="neo-btn-secondary mr-2">
        <i class="fas fa-edit mr-1"></i> Edit
      </a>
      <form action="{{ route('admin.holidays.destroy', $holiday) }}" method="POST" class="inline" onsubmit="return confirm('Delete this holiday?')">
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