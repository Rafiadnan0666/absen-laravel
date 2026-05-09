@extends('layouts.employee')

@section('page-title', 'My Attendance Logs')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black text-slate-700">My Attendance Logs</h1>
        <a href="{{ route('employee.attendances.create') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
            Check In/Out
        </a>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Date/Time</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Type</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Latitude</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Longitude</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Device</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-3 text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($log->waktu_log)->format('d M Y H:i:s') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block py-1 px-2 text-xs rounded-lg text-white font-bold bg-gradient-to-tl
                                    @if($log->tipe_log == 'check_in') from-green-600 to-lime-400
                                    @else from-yellow-600 to-amber-400 @endif">
                                    {{ strtoupper($log->tipe_log) }}
                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $log->latitude ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $log->longitude ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block py-1 px-2 text-xs rounded-lg text-white font-bold bg-gradient-to-tl from-slate-600 to-slate-400">
                                    {{ strtoupper($log->device) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-4 py-8 text-center text-slate-400">No attendance logs</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
@endsection
