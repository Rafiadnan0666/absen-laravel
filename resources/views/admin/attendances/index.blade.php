@extends('admin.dashboard.layout')

@section('title', 'Attendance Records - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">ATTENDANCE RECORDS</h6>
      <a href="{{ route('admin.attendances.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Attendance
      </a>
    </div>

    @if(session('success'))
      <div class="neo-alert-success mb-4">
        {{ session('success') }}
      </div>
    @endif

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
          <tr class="border-b-2 border-black hover:bg-neo-light">
            <td class="px-4 py-3 font-bold">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</td>
            <td class="px-4 py-3">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
            <td class="px-4 py-3">{{ $attendance->check_in ?? '-' }}</td>
            <td class="px-4 py-3">{{ $attendance->check_out ?? '-' }}</td>
            <td class="px-4 py-3">
              @if($attendance->status_hadir == 'present')
                <span class="neo-badge neo-badge-green">PRESENT</span>
              @elseif($attendance->status_hadir == 'late')
                <span class="neo-badge neo-badge-yellow">LATE</span>
              @else
                <span class="neo-badge neo-badge-red">ABSENT</span>
              @endif
            </td>
            <td class="px-4 py-3">{{ $attendance->jam_kerja ? $attendance->jam_kerja->format('H:i') : '-' }}</td>
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
      {{ $attendances->links() }}
    </div>
  </div>
</div>
@endsection