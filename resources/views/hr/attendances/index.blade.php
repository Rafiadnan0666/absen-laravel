@extends('hr.dashboard.layout')

@section('title', 'HR Attendance - ABS')
@section('page-title', 'Attendance')

@section('content')
    <h1 class="neo-section-title">ATTENDANCE RECORDS</h1>

    <div class="neo-card">
        <div class="p-4 border-b-4 border-black">
            <h6 class="mb-0 font-bold text-xl">All Attendance Records</h6>
        </div>
        <div class="p-4">
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Work Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $item)
                        <tr>
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td>{{ $item->check_in ?? '-' }}</td>
                            <td>{{ $item->check_out ?? '-' }}</td>
                            <td>
                                @if($item->status_hadir == 'present')
                                    <span class="neo-badge neo-badge-green">
                                        {{ strtoupper($item->status_hadir) }}
                                    </span>
                                @elseif($item->status_hadir == 'late')
                                    <span class="neo-badge neo-badge-yellow">
                                        {{ strtoupper($item->status_hadir) }}
                                    </span>
                                @else
                                    <span class="neo-badge neo-badge-red">
                                        {{ strtoupper($item->status_hadir) }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($item->check_in && $item->check_out)
                                    @php
                                        $checkIn = \Carbon\Carbon::parse($item->check_in);
                                        $checkOut = \Carbon\Carbon::parse($item->check_out);
                                        $hours = $checkOut->diffInMinutes($checkIn) / 60;
                                    @endphp
                                    {{ number_format($hours, 1) }}h
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center font-bold py-4">No attendance records</td>
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