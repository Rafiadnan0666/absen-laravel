@extends('admin.dashboard.layout')
 
@section('title', 'Admin Dashboard - ABS')
 
@section('content')
<div class="mt-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 auto-rows-min">
  <!-- Welcome Section - spans full row -->
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 md:col-span-2 lg:col-span-3 xl:col-span-4">
    <div class="flex flex-wrap items-center justify-between">
      <div>
        <h5 class="mb-0 text-slate-400">Welcome back,</h5>
        <h1 class="mb-0 font-bold text-slate-700">{{ auth()->user()->nama_lengkap }}</h1>
        <p class="mb-0 text-slate-400">Here's what's happening with your ABS system today.</p>
      </div>
      <div class="flex gap-2 mt-2 md:mt-0">
        <span class="px-4 py-2 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
          <i class="fas fa-check-circle mr-1"></i> System Active
        </span>
      </div>
    </div>
  </div>
  
  <!-- Stats Cards Row -->
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
    <div class="flex items-center justify-between">
      <div>
        <p class="mb-0 text-xs font-semibold text-slate-400">TOTAL USERS</p>
        <p class="text-2xl font-bold text-slate-700 mb-0">{{ $totalUsers }}</p>
      </div>
      <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg">
        <i class="fas fa-users"></i>
      </div>
    </div>
    <div class="mt-3 pt-3 border-t border-slate-100">
      <span class="text-xs text-slate-400"><i class="fas fa-arrow-up text-green-500 mr-1"></i> All registered users</span>
    </div>
  </div>
  
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
    <div class="flex items-center justify-between">
      <div>
        <p class="mb-0 text-xs font-semibold text-slate-400">EMPLOYEES</p>
        <p class="text-2xl font-bold text-slate-700 mb-0">{{ $totalEmployees }}</p>
      </div>
      <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center text-white shadow-lg">
        <i class="fas fa-user-tie"></i>
      </div>
    </div>
    <div class="mt-3 pt-3 border-t border-slate-100">
      <span class="text-xs text-slate-400"><i class="fas fa-arrow-up text-green-500 mr-1"></i> Active workforce</span>
    </div>
  </div>
  
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
    <div class="flex items-center justify-between">
      <div>
        <p class="mb-0 text-xs font-semibold text-slate-400">DEPARTMENTS</p>
        <p class="text-2xl font-bold text-slate-700 mb-0">{{ $totalDepartments }}</p>
      </div>
      <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-purple-600 to-pink-500 flex items-center justify-center text-white shadow-lg">
        <i class="fas fa-building"></i>
      </div>
    </div>
    <div class="mt-3 pt-3 border-t border-slate-100">
      <span class="text-xs text-slate-400"><i class="fas fa-layer-group text-purple-400 mr-1"></i> Company divisions</span>
    </div>
  </div>
  
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
    <div class="flex items-center justify-between">
      <div>
        <p class="mb-0 text-xs font-semibold text-slate-400">TOTAL LEAVES</p>
        <p class="text-2xl font-bold text-slate-700 mb-0">{{ $totalLeaves }}</p>
      </div>
      <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-red-600 to-orange-400 flex items-center justify-center text-white shadow-lg">
        <i class="fas fa-calendar-alt"></i>
      </div>
    </div>
    <div class="mt-3 pt-3 border-t border-slate-100">
      <span class="text-xs text-slate-400"><i class="fas fa-clock text-orange-400 mr-1"></i> Total leave requests</span>
    </div>
  </div>
  
  <!-- Recent Attendance - spans 2 cols -->
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border md:col-span-1 lg:col-span-2 xl:col-span-2">
    <div class="flex items-center justify-between p-4 pb-0">
      <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-check text-green-500 mr-2"></i>Recent Attendance</h6>
      <a href="#" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
    </div>
    <div class="flex-auto p-4">
      <div class="overflow-x-auto">
        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
          <thead class="align-bottom">
            <tr>
              <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
              <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Date</th>
              <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
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
                  @elseif($attendance->status_hadir == 'late') bg-gradient-to-tl from-red-600 to-orange-400
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
  
  <!-- Recent Leaves - spans 2 cols -->
  <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border md:col-span-1 lg:col-span-2 xl:col-span-2">
    <div class="flex items-center justify-between p-4 pb-0">
      <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-alt text-purple-500 mr-2"></i>Recent Leave Requests</h6>
      <a href="#" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
    </div>
    <div class="flex-auto p-4">
      <div class="overflow-x-auto">
        <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
          <thead class="align-bottom">
            <tr>
              <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
              <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Type</th>
              <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
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
                  @elseif($leave->status_pengajuan == 'pending') bg-gradient-to-tl from-purple-600 to-pink-500
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
@endsection
