@extends('hr.dashboard.layout')

@section('title', 'HR Attendance - ABS')
@section('page-title', 'Attendance')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">

    <!-- Stats Recap -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3 mb-4">
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Total</p>
        <p class="text-lg font-bold text-slate-700 mb-0">{{ $total }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-green-500">Present</p>
        <p class="text-lg font-bold text-green-600 mb-0">{{ $totalPresent }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-orange-500">Late</p>
        <p class="text-lg font-bold text-orange-600 mb-0">{{ $totalLate }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-red-500">Absent</p>
        <p class="text-lg font-bold text-red-600 mb-0">{{ $totalAbsent }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Today Check-ins</p>
        <p class="text-lg font-bold text-slate-700 mb-0">{{ $todayTotal }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">On Time</p>
        <p class="text-lg font-bold text-green-600 mb-0">{{ $todayOnTime }}%</p>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
          <h6 class="text-xl font-bold">Attendance Records</h6>
          <div class="flex items-center gap-2 w-full sm:w-auto flex-wrap">
            <form method="GET" action="{{ route('hr.attendances.index') }}" class="flex items-center gap-2 flex-wrap">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Search employee..." class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-32">
              <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-28">
              <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-28">
              <select name="status" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
                <option value="">All Status</option>
                <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                <option value="late" {{ request('status') == 'late' ? 'selected' : '' }}>Late</option>
                <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
              </select>
              <button type="submit" class="px-3 py-2 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 transition-all">
                <i class="fas fa-search"></i>
              </button>
              <a href="{{ route('hr.attendances.export', request()->query()) }}" class="inline-block px-4 py-2 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 bg-gradient-to-tl from-green-600 to-lime-400 text-white whitespace-nowrap">
                <i class="fas fa-download mr-1"></i> CSV
              </a>
            </form>
          </div>
        </div>
      </div>
      <div class="flex-auto p-6 px-0 pt-0 pb-2 relative">
        @if(session('success'))
          <div class="p-4 mb-4 mx-6 text-sm text-green-800 rounded-lg bg-green-50" role="alert">{{ session('success') }}</div>
        @endif
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Date</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Check In</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Check Out</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Location</th>
              </tr>
            </thead>
            <tbody>
              @forelse($attendances as $item)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $item->user->nama_lengkap ?? 'N/A' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-slate-400">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-slate-600">{{ $item->check_in ?? '-' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-slate-600">{{ $item->check_out ?? '-' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="px-3 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white font-bold
                    @if($item->status_hadir == 'present') bg-gradient-to-tl from-green-600 to-lime-400
                    @elseif($item->status_hadir == 'late') bg-gradient-to-tl from-orange-500 to-yellow-400
                    @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
                    {{ strtoupper($item->status_hadir) }}
                  </span>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-slate-500">{{ $item->location->nama_lokasi ?? '-' }}</p>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="p-4 text-center text-slate-400">No attendance records</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-4 pt-3">
          {{ $attendances->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
