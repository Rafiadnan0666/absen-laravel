@extends('layouts.employee')

@section('page-title', 'My Attendance')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4 fade-in-up">
        <h1 class="text-2xl font-black">MY ATTENDANCE</h1>
        <a href="{{ route('employee.attendances.create') }}" class="neo-btn-primary neo-btn-sm pulse-glow">CHECK IN/OUT</a>
    </div>

    @if(session('success'))
        <div class="neo-alert-success mb-6 shake">{{ session('success') }}</div>
    @endif

    <x-advanced-filters :action="route('employee.attendances.index')" :filters="[
        'date_from' => ['type' => 'date', 'label' => 'From'],
        'date_to' => ['type' => 'date', 'label' => 'To'],
        'status' => ['type' => 'select', 'label' => 'Status', 'options' => [
            'present' => 'Present',
            'late' => 'Late',
            'absent' => 'Absent',
        ]],
        'month' => ['type' => 'month', 'label' => 'Month'],
    ]" />

    <div class="neo-card fade-in-up fade-in-up-d2">
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
                    <tr class="hover-lift" style="transition: transform 0.2s, box-shadow 0.2s;">
                        <td class="font-bold">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
                        <td>
                            <span class="inline-flex items-center gap-1">
                                <span class="text-neo-green">{{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}</span>
                            </span>
                        </td>
                        <td>
                            <span class="inline-flex items-center gap-1">
                                <span class="text-neo-cyan">{{ $attendance->check_out ? $attendance->check_out->format('H:i') : '-' }}</span>
                            </span>
                        </td>
                        <td>
                            @if($attendance->status_hadir == 'present')
                                <span class="neo-badge neo-badge-green status-pulse">PRESENT</span>
                            @elseif($attendance->status_hadir == 'late')
                                <span class="neo-badge neo-badge-yellow">LATE</span>
                            @else
                                <span class="neo-badge neo-badge-red">ABSENT</span>
                            @endif
                        </td>
                        <td class="font-bold">{{ $attendance->jam_kerja ? $attendance->jam_kerja->format('H:i') : '-' }}</td>
                        <td class="{{ $attendance->menit_telat > 0 ? 'text-neo-red font-bold' : '' }}">{{ $attendance->menit_telat ?? 0 }}</td>
                        <td class="{{ $attendance->menit_pulang_cepat > 0 ? 'text-neo-orange font-bold' : '' }}">{{ $attendance->menit_pulang_cepat ?? 0 }}</td>
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
            {{ $attendances->links('vendor.pagination.neo') }}
        </div>
    </div>
@endsection
