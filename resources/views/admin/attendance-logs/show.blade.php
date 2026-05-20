@extends('admin.dashboard.layout')

@section('title', 'View Attendance Log - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="neo-section-title">ATTENDANCE LOG DETAILS</h6>
        <a href="{{ route('admin.attendance-logs.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
      </div>
    </div>
    <div>
      <div class="mb-4">
        <label class="neo-label">ID</label>
        <p class="text-sm">{{ $attendanceLog->id }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">User</label>
        <p class="text-sm">{{ $attendanceLog->user->nama_lengkap ?? 'N/A' }} ({{ $attendanceLog->user->email ?? 'N/A' }})</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Type</label>
        <span class="neo-badge">
          {{ ucfirst(str_replace('_', ' ', $attendanceLog->tipe_log)) }}
        </span>
      </div>
      <div class="mb-4">
        <label class="neo-label">Time</label>
        <p class="text-sm">{{ $attendanceLog->waktu_log->format('d M Y H:i:s') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Location</label>
        <p class="text-sm">
          @if($attendanceLog->latitude && $attendanceLog->longitude)
            Latitude: {{ $attendanceLog->latitude }}, Longitude: {{ $attendanceLog->longitude }}
            <span class="text-xs ml-2">({{ $attendanceLog->jarak_meter ?? '?' }}m from office)</span>
          @else
            N/A
          @endif
        </p>
        @if($attendanceLog->latitude && $attendanceLog->longitude)
        <div id="logMap" style="height:250px;border:3px solid #000;margin-top:8px;"></div>
        @endif
      </div>
      <div class="mb-4">
        <label class="neo-label">Photo</label>
        @if($attendanceLog->foto_path)
          <img src="{{ asset('storage/' . $attendanceLog->foto_path) }}" alt="Attendance Photo" class="max-w-xs border-3 border-black shadow-neo">
        @else
          <p class="text-sm">No photo available</p>
        @endif
      </div>
      <div class="mb-4">
        <label class="neo-label">Device</label>
        <p class="text-sm">{{ $attendanceLog->device ?? 'N/A' }}</p>
      </div>
      <div class="flex justify-end mt-6">
        <form action="{{ route('admin.attendance-logs.destroy', $attendanceLog) }}" method="POST" class="inline" onsubmit="return confirm('Delete this attendance log?')">
          @csrf
          @method('DELETE')
          <button type="submit" class="neo-btn-danger">
            <i class="fas fa-trash mr-1"></i> Delete
          </button>
        </form>
      </div>
    </div>
  </div>
</div>
@push('scripts')
@if($attendanceLog->latitude && $attendanceLog->longitude)
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const lat = {{ $attendanceLog->latitude }};
    const lng = {{ $attendanceLog->longitude }};
    const map = L.map('logMap').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
    L.marker([lat, lng]).addTo(map).bindPopup('<b>Check {{ ucfirst(str_replace('_', ' ', $attendanceLog->tipe_log)) }}</b><br>{{ $attendanceLog->waktu_log->format('d M Y H:i') }}').openPopup();
  });
</script>
@endif
@endpush
@endsection
