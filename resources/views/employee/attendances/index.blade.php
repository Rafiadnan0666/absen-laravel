@extends('layouts.employee')

@section('page-title', 'My Attendance')

@section('content')
    <h1 class="text-4xl font-black mb-8">My Attendance</h1>

    @if(session('success'))
        <div class="neo-card mb-6">
            <p class="font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <div class="neo-card">
        <div class="neo-table-container">
            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                        <th>Work Hours</th>
                        <th>Late (min)</th>
                        <th>Early Out (min)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendances as $attendance)
                    <tr>
                        <td class="font-bold">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
                        <td>{{ $attendance->check_in ?? '-' }}</td>
                        <td>{{ $attendance->check_out ?? '-' }}</td>
                        <td>
                            @if($attendance->status_hadir == 'present')
                                <span class="neo-badge neo-badge-green">PRESENT</span>
                            @elseif($attendance->status_hadir == 'late')
                                <span class="neo-badge neo-badge-yellow">LATE</span>
                            @else
                                <span class="neo-badge neo-badge-red">ABSENT</span>
                            @endif
                        </td>
                        <td>{{ $attendance->jam_kerja ?? '-' }}</td>
                        <td>{{ $attendance->menit_telat ?? 0 }}</td>
                        <td>{{ $attendance->menit_pulang_cepat ?? 0 }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 font-bold">No attendance records</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $attendances->links() }}
        </div>
    </div>
@endsection