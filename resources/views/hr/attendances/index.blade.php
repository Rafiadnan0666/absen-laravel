@extends('hr.dashboard.layout')

@section('title', 'HR Attendance - ABS')
@section('page-title', 'Attendance')

@section('content')
    <h1 class="text-4xl font-black mb-6 text-slate-700">Attendance Records</h1>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <div class="flex justify-between items-center">
                <h6 class="mb-0 font-bold text-slate-700">All Attendance Records</h6>
            </div>
        </div>
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Date</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances)
                        <tr>
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td>{{ $item->check_in ?? '-' }}</td>
                            <td>{{ $item->check_out ?? '-' }}</td>
                            <td>
                                <span class="neo-btn text-xs px-2 py-1
                                    @if($item->status_hadir == 'present') bg-green-200
                                    @elseif($item->status_hadir == 'late') bg-yellow-200
                                    @else bg-red-200 @endif">
                                    {{ strtoupper($item->status_hadir) }}
                                </span>
                            </td>
                            <td>{{ $item->location->nama_lokasi ?? 'N/A' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center font-bold text-gray-500 py-4">No attendance records</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $attendances->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
