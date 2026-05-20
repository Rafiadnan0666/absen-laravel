@extends('admin.dashboard.layout')

@section('title', 'View User Shift - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">USER SHIFT DETAILS</h6>
      <a href="{{ route('admin.user-shifts.index') }}" class="neo-btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> BACK
      </a>
    </div>
    <div class="mb-4">
      <label class="neo-label">ID</label>
      <p class="text-sm">{{ $userShift->id }}</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">EMPLOYEE</label>
      <p class="text-sm">{{ $userShift->user->nama_lengkap ?? 'N/A' }} ({{ $userShift->user->email ?? 'N/A' }})</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">SHIFT</label>
      <p class="text-sm">{{ $userShift->shift->nama_shift ?? 'N/A' }} ({{ $userShift->shift->jam_masuk ?? '' }} - {{ $userShift->shift->jam_pulang ?? '' }})</p>
    </div>
    <div class="mb-4">
      <label class="neo-label">DATE</label>
      <p class="text-sm">{{ $userShift->tanggal_shift->format('d M Y') }}</p>
    </div>
    <div class="flex justify-end mt-6">
      <a href="{{ route('admin.user-shifts.edit', $userShift) }}" class="neo-btn-secondary mr-2">
        <i class="fas fa-edit mr-1"></i> EDIT
      </a>
      <form action="{{ route('admin.user-shifts.destroy', $userShift) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user shift?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="neo-btn-danger">
          <i class="fas fa-trash mr-1"></i> DELETE
        </button>
      </form>
    </div>
  </div>
</div>
@endsection