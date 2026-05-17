@extends('layouts.employee')

@section('page-title', 'My Attendance Logs')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-black">My Attendance Logs</h1>
        <a href="{{ route('employee.attendances.create') }}" class="neo-btn-primary">Check In/Out</a>
    </div>

    <div class="neo-card">
        <div class="neo-table-container">
            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Date/Time</th>
                        <th>Type</th>
                        <th>Latitude</th>
                        <th>Longitude</th>
                        <th>Device</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr>
                        <td class="font-bold">{{ \Carbon\Carbon::parse($log->waktu_log)->format('d M Y H:i:s') }}</td>
                        <td><span class="neo-badge neo-badge-cyan">{{ strtoupper($log->tipe_log) }}</span></td>
                        <td>{{ $log->latitude ?? '-' }}</td>
                        <td>{{ $log->longitude ?? '-' }}</td>
                        <td><span class="neo-badge neo-badge-yellow">{{ strtoupper($log->device) }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-8 font-bold">No attendance logs</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $logs->links() }}
        </div>
    </div>
@endsection