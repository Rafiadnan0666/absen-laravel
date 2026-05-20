@extends('admin.dashboard.layout')

@section('title', 'View Shift - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="neo-section-title">SHIFT DETAILS</h6>
        <div class="flex gap-2">
          <a href="{{ route('admin.shifts.edit', $shift) }}" class="neo-btn-primary">
            Edit
          </a>
          <a href="{{ route('admin.shifts.index') }}" class="neo-btn-secondary">
            Back
          </a>
        </div>
      </div>
    </div>

    <div class="space-y-4">
      <div>
        <label class="neo-label">ID</label>
        <p class="font-bold">{{ $shift->id }}</p>
      </div>
      <div>
        <label class="neo-label">Shift Name</label>
        <p class="font-bold">{{ $shift->nama_shift }}</p>
      </div>
      <div>
        <label class="neo-label">Check In Time</label>
        <p>{{ $shift->jam_masuk }}</p>
      </div>
      <div>
        <label class="neo-label">Check Out Time</label>
        <p>{{ $shift->jam_pulang }}</p>
      </div>
      <div>
        <label class="neo-label">Late Tolerance (minutes)</label>
        <p>{{ $shift->toleransi_telat_menit }}</p>
      </div>
      <div>
        <label class="neo-label">Created At</label>
        <p>{{ $shift->created_at->format('d M Y H:i') }}</p>
      </div>
      <div>
        <label class="neo-label">Assigned Users ({{ $shift->userShifts->count() }})</label>
        <div class="overflow-x-auto mt-2">
          <table class="neo-table w-full mt-2">
            <thead>
              <tr>
                <th class="text-left p-2 border-b-2 border-black font-bold uppercase text-xs">User</th>
                <th class="text-left p-2 border-b-2 border-black font-bold uppercase text-xs">Date</th>
              </tr>
            </thead>
            <tbody>
              @forelse($shift->userShifts as $userShift)
              <tr class="border-b border-black">
                <td class="p-2 text-sm">{{ $userShift->user->nama_lengkap ?? 'N/A' }}</td>
                <td class="p-2 text-sm">{{ $userShift->tanggal_shift }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="2" class="p-2 text-center text-sm">No users assigned</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection