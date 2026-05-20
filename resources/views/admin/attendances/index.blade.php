@extends('admin.dashboard.layout')

@section('title', 'Attendance Records - Admin')

@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center mb-2 border-b-3 border-black pb-4 fade-in-up">
    <h6 class="text-xl font-bold">ATTENDANCE RECORDS</h6>
    <a href="{{ route('admin.attendances.create') }}" class="neo-btn-primary neo-btn-sm pulse-glow">
      <i class="fas fa-plus mr-1"></i> Add Attendance
    </a>
  </div>

  @if(session('success'))
    <div class="neo-alert-success mb-6 shake">{{ session('success') }}</div>
  @endif

  <x-advanced-filters :action="route('admin.attendances.index')" :filters="[
    'date_from' => ['type' => 'date', 'label' => 'From'],
    'date_to' => ['type' => 'date', 'label' => 'To'],
    'status' => ['type' => 'select', 'label' => 'Status', 'options' => [
      'present' => 'Present',
      'late' => 'Late',
      'absent' => 'Absent',
    ]],
    'user_id' => ['type' => 'select', 'label' => 'Employee', 'options' => $users->pluck('nama_lengkap', 'id')->toArray()],
  ]" />

  <div class="neo-card fade-in-up fade-in-up-d2">
    <div class="neo-table-container overflow-x-auto">
      <table class="neo-table w-full">
        <thead>
          <tr class="bg-neo-dark">
            <th class="px-4 py-3 text-left font-bold uppercase text-sm border-b-3 border-black">EMPLOYEE</th>
            <th class="px-4 py-3 text-left font-bold uppercase text-sm border-b-3 border-black">DATE</th>
            <th class="px-4 py-3 text-left font-bold uppercase text-sm border-b-3 border-black">CHECK IN</th>
            <th class="px-4 py-3 text-left font-bold uppercase text-sm border-b-3 border-black">CHECK OUT</th>
            <th class="px-4 py-3 text-left font-bold uppercase text-sm border-b-3 border-black">STATUS</th>
            <th class="px-4 py-3 text-left font-bold uppercase text-sm border-b-3 border-black">WORK HOURS</th>
          </tr>
        </thead>
        <tbody>
          @forelse($attendances as $attendance)
          <tr class="border-b-2 border-black hover:bg-neo-light hover-lift" style="transition: transform 0.2s, box-shadow 0.2s, background-color 0.2s;">
            <td class="px-4 py-3 font-bold">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</td>
            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
            <td class="px-4 py-3"><span class="text-neo-green font-bold">{{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}</span></td>
            <td class="px-4 py-3"><span class="text-neo-cyan font-bold">{{ $attendance->check_out ? $attendance->check_out->format('H:i') : '-' }}</span></td>
            <td class="px-4 py-3">
              @if($attendance->status_hadir == 'present')
                <span class="neo-badge neo-badge-green status-pulse">PRESENT</span>
              @elseif($attendance->status_hadir == 'late')
                <span class="neo-badge neo-badge-yellow">LATE</span>
              @else
                <span class="neo-badge neo-badge-red">ABSENT</span>
              @endif
            </td>
            <td class="px-4 py-3 font-bold">{{ $attendance->jam_kerja ? $attendance->jam_kerja->format('H:i') : '-' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-4 py-8 text-center font-bold">No attendance records found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $attendances->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection
