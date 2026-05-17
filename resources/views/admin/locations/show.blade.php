@extends('admin.dashboard.layout')

@section('title', 'View Location - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">LOCATION DETAILS</h6>
        <a href="{{ route('admin.locations.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> BACK
        </a>
      </div>
    </div>
    <div>
      <div class="mb-4">
        <label class="neo-label">LOCATION NAME</label>
        <p class="font-bold text-lg">{{ $location->nama_lokasi }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">LATITUDE</label>
        <p class="neo-input bg-[#f0f0f0]">{{ $location->latitude }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">LONGITUDE</label>
        <p class="neo-input bg-[#f0f0f0]">{{ $location->longitude }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">RADIUS (METERS)</label>
        <span class="neo-badge neo-badge-green">{{ $location->radius_meter }}m</span>
      </div>
      <div class="mb-4">
        <label class="neo-label">ATTENDANCE COUNT</label>
        <span class="neo-badge neo-badge-cyan">{{ $location->attendances_count ?? $location->attendances()->count() }}</span>
      </div>
      <div class="flex justify-end mt-6 space-x-2">
        <a href="{{ route('admin.locations.edit', $location) }}" class="neo-btn-primary">
          <i class="fas fa-edit mr-1"></i> EDIT
        </a>
        <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="inline" onsubmit="return confirm('DELETE THIS LOCATION?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="neo-btn-danger">
            <i class="fas fa-trash mr-1"></i> DELETE
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection