@extends('layouts.employee')

@section('page-title', 'My Attendance')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">My Attendance</h1>

    @if(session('success'))
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="flex-auto p-4">
                <p class="font-bold text-slate-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Date</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Check In</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Check Out</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Work Hours</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Late (min)</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Early Out (min)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($attendances as $attendance)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-3 text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($attendance->tanggal)->format('d M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $attendance->check_in ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $attendance->check_out ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block py-1 px-2 text-xs rounded-lg text-white font-bold bg-gradient-to-tl
                                    @if($attendance->status_hadir == 'present') from-green-600 to-lime-400
                                    @elseif($attendance->status_hadir == 'late') from-yellow-600 to-orange-400
                                    @else from-red-600 to-rose-400 @endif">
                                    {{ strtoupper($attendance->status_hadir) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $attendance->jam_kerja ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $attendance->menit_telat ?? 0 }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $attendance->menit_pulang_cepat ?? 0 }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-8 text-center text-slate-400">No attendance records</td>
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
