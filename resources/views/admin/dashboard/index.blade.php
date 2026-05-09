@extends('admin.dashboard.layout')

@section('title', 'Admin Dashboard - ABS')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="w-full max-w-full flex-none px-3">
    <div class="relative flex min-w-0 flex-col mb-6 break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-soft-xl">
      <div class="flex-auto p-6">
        <div class="flex flex-wrap -mx-3">
          <div class="w-full max-w-full flex-none px-3">
            <div class="mb-0">
              <h5 class="mb-0 text-slate-400">Welcome back,</h5>
              <h1 class="mb-0 font-bold text-slate-700">{{ auth()->user()->nama_lengkap }}</h1>
              <p class="mb-0 text-slate-400">Here's what's happening with your ABS system today.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="flex flex-wrap -mx-3 mt-6">
  <div class="w-full max-w-full flex-none px-3 sm:w-1/2 xl:w-1/4">
    <div class="relative flex min-w-0 flex-col mb-6 break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-soft-xl">
      <div class="flex-auto p-4">
        <div class="flex flex-row justify-between">
          <div>
            <div class="font-bold text-xs text-slate-400 mb-2">TOTAL USERS</div>
            <h5 class="font-bold text-2xl text-slate-700">{{ \App\Models\User::count() }}</h5>
          </div>
          <div class="flex items-center">
            <div class="bg-gradient-to-tl from-purple-700 to-pink-500 shadow-soft-2xl inline-block whitespace-nowrap rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 h-12 w-12 flex items-center justify-center">
              <i class="fas fa-users text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="w-full max-w-full flex-none px-3 sm:w-1/2 xl:w-1/4">
    <div class="relative flex min-w-0 flex-col mb-6 break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-soft-xl">
      <div class="flex-auto p-4">
        <div class="flex flex-row justify-between">
          <div>
            <div class="font-bold text-xs text-slate-400 mb-2">PRESENT TODAY</div>
            <h5 class="font-bold text-2xl text-slate-700">
              {{ \App\Models\Attendance::whereDate('tanggal', today())->where('status_hadir', 'present')->count() }}
            </h5>
          </div>
          <div class="flex items-center">
            <div class="bg-gradient-to-tl from-green-600 to-lime-400 shadow-soft-2xl inline-block whitespace-nowrap rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 h-12 w-12 flex items-center justify-center">
              <i class="fas fa-calendar-check text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="w-full max-w-full flex-none px-3 sm:w-1/2 xl:w-1/4">
    <div class="relative flex min-w-0 flex-col mb-6 break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-soft-xl">
      <div class="flex-auto p-4">
        <div class="flex flex-row justify-between">
          <div>
            <div class="font-bold text-xs text-slate-400 mb-2">PENDING LEAVES</div>
            <h5 class="font-bold text-2xl text-slate-700">
              {{ \App\Models\Leave::where('status_pengajuan', 'pending')->count() }}
            </h5>
          </div>
          <div class="flex items-center">
            <div class="bg-gradient-to-tl from-yellow-600 to-yellow-400 shadow-soft-2xl inline-block whitespace-nowrap rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 h-12 w-12 flex items-center justify-center">
              <i class="fas fa-calendar-times text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="w-full max-w-full flex-none px-3 sm:w-1/2 xl:w-1/4">
    <div class="relative flex min-w-0 flex-col mb-6 break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-soft-xl">
      <div class="flex-auto p-4">
        <div class="flex flex-row justify-between">
          <div>
            <div class="font-bold text-xs text-slate-400 mb-2">PENDING REIMBURSEMENTS</div>
            <h5 class="font-bold text-2xl text-slate-700">
              {{ \App\Models\Reimbursement::where('status', 'pending')->count() }}
            </h5>
          </div>
          <div class="flex items-center">
            <div class="bg-gradient-to-tl from-red-600 to-rose-400 shadow-soft-2xl inline-block whitespace-nowrap rounded-lg bg-white bg-center stroke-0 text-center xl:p-2.5 h-12 w-12 flex items-center justify-center">
              <i class="fas fa-receipt text-white"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="flex flex-wrap -mx-3 mt-6">
  <div class="w-full max-w-full flex-none px-3 xl:w-1/2">
    <div class="relative flex min-w-0 flex-col mb-6 break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-soft-xl">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="mb-0 text-xl font-bold">Recent Attendance</h6>
      </div>
      <div class="flex-auto p-6 px-0 pt-0 pb-2">
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Date</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse(\App\Models\Attendance::with('user')->latest('tanggal')->take(5)->get() as $attendance)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-slate-400">{{ $attendance->tanggal->format('d M Y') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
                    @if($attendance->status_hadir == 'present') bg-gradient-to-tl from-green-600 to-lime-400
                    @elseif($attendance->status_hadir == 'late') bg-gradient-to-tl from-yellow-600 to-yellow-400
                    @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
                    {{ strtoupper($attendance->status_hadir) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="p-4 text-center text-slate-400">No attendance records</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <div class="w-full max-w-full flex-none px-3 xl:w-1/2">
    <div class="relative flex min-w-0 flex-col mb-6 break-words rounded-2xl border-0 border-solid border-transparent bg-white bg-clip-border shadow-soft-xl">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="mb-0 text-xl font-bold">Recent Leave Requests</h6>
      </div>
      <div class="flex-auto p-6 px-0 pt-0 pb-2">
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Type</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse(\App\Models\Leave::with('user')->latest('tanggal_mulai')->take(5)->get() as $leave)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $leave->user->nama_lengkap ?? 'N/A' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="bg-gradient-to-tl from-blue-600 to-cyan-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">{{ ucfirst($leave->tipe_cuti) }}</span>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
                    @if($leave->status_pengajuan == 'approved') bg-gradient-to-tl from-green-600 to-lime-400
                    @elseif($leave->status_pengajuan == 'pending') bg-gradient-to-tl from-yellow-600 to-yellow-400
                    @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
                    {{ strtoupper($leave->status_pengajuan) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="p-4 text-center text-slate-400">No leave requests</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
