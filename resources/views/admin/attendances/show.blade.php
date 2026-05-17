@extends('admin.dashboard.layout')

@section('title', 'View Attendance - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">ATTENDANCE DETAILS</h6>
        <a href="{{ route('admin.attendances.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
      </div>
    </div>

    <div class="space-y-4">
      <div class="flex flex-col">
        <label class="neo-label">ID</label>
        <p class="text-sm font-bold">{{ $attendance->id }}</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">EMPLOYEE</label>
        <p class="text-sm">{{ $attendance->user->nama_lengkap ?? 'N/A' }} ({{ $attendance->user->email ?? 'N/A' }})</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">DATE</label>
        <p class="text-sm">{{ $attendance->tanggal->format('d M Y') }}</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">CHECK IN</label>
        <p class="text-sm">{{ $attendance->check_in ? $attendance->check_in->format('H:i:s') : '-' }}</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">CHECK OUT</label>
        <p class="text-sm">{{ $attendance->check_out ? $attendance->check_out->format('H:i:s') : '-' }}</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">STATUS</label>
        @if($attendance->status_hadir == 'present')
          <span class="neo-badge neo-badge-green">PRESENT</span>
        @elseif($attendance->status_hadir == 'late')
          <span class="neo-badge neo-badge-yellow">LATE</span>
        @else
          <span class="neo-badge neo-badge-red">ABSENT</span>
        @endif
      </div>
      <div class="flex flex-col">
        <label class="neo-label">WORK HOURS</label>
        <p class="text-sm">{{ $attendance->jam_kerja ? $attendance->jam_kerja->format('H:i') : '-' }}</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">OVERTIME HOURS</label>
        <p class="text-sm">{{ $attendance->jam_lembur ? $attendance->jam_lembur->format('H:i') : '-' }}</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">LATE MINUTES</label>
        <p class="text-sm">{{ $attendance->menit_telat ?? '-' }} minutes</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">EARLY LEAVE MINUTES</label>
        <p class="text-sm">{{ $attendance->menit_pulang_cepat ?? '-' }} minutes</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">LOCATION</label>
        <p class="text-sm">{{ $attendance->location->nama_lokasi ?? 'N/A' }}</p>
      </div>
      <div class="flex flex-col">
        <label class="neo-label">FACE VERIFIED</label>
        @if($attendance->face_verified)
          <span class="neo-badge neo-badge-green">YES</span>
        @else
          <span class="neo-badge neo-badge-red">NO</span>
        @endif
      </div>
      <div class="flex gap-2 mt-6">
        <a href="{{ route('admin.attendances.edit', $attendance) }}" class="neo-btn-primary">
          <i class="fas fa-edit mr-1"></i> Edit
        </a>
        <form action="{{ route('admin.attendances.destroy', $attendance) }}" method="POST" class="inline" onsubmit="return confirm('Delete this attendance record?')">
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