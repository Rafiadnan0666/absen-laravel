@extends('hr.dashboard.layout')

@section('title', 'HR Attendance - ABS')
@section('page-title', 'Attendance')

@section('content')
    <h1 class="neo-section-title fade-in-up">ATTENDANCE RECORDS</h1>

    @if(session('success'))
        <div class="neo-alert-success mb-6 shake">{{ session('success') }}</div>
    @endif




    
    <x-advanced-filters :action="route('hr.attendances.index')" :filters="[
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
        <div class="flex justify-between items-center p-4 border-b-3 border-black">
            <h2 class="font-black text-xl">All Attendance Records</h2>
        </div>
        <div class="p-4"
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
                        <tr class="hover-lift" style="transition: transform 0.2s, box-shadow 0.2s;">
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td><span class="text-neo-green font-bold">{{ $item->check_in ? $item->check_in->format('H:i') : '-' }}</span></td>
                            <td><span class="text-neo-cyan font-bold">{{ $item->check_out ? $item->check_out->format('H:i') : '-' }}</span></td>
                            <td>
                                @if($item->status_hadir == 'present')
                                    <span class="neo-badge neo-badge-green status-pulse">{{ strtoupper($item->status_hadir) }}</span>
                                @elseif($item->status_hadir == 'late')
                                    <span class="neo-badge neo-badge-yellow">{{ strtoupper($item->status_hadir) }}</span>
                                @else
                                    <span class="neo-badge neo-badge-red">{{ strtoupper($item->status_hadir) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($item->jam_kerja)
                                    {{ $item->jam_kerja->format('H:i') }}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center font-bold py-8">No attendance records</td>
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
