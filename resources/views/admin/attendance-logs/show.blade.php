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
        <p class="text-sm">{{ $attendanceLog->user->name ?? 'N/A' }} ({{ $attendanceLog->user->email ?? 'N/A' }})</p>
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
          @else
            N/A
          @endif
        </p>
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
@endsection
