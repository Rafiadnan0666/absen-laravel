@extends('admin.dashboard.layout')
 
@section('title', 'Admin Dashboard - ABS')
 
@section('page-title', 'Dashboard')

@section('content')
<div class="mt-6 mx-4">
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 auto-rows-min">

    <!-- Welcome Section -->
    <div id="tour-welcome" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-6 md:col-span-2 lg:col-span-3 xl:col-span-4">
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
          <span class="px-4 py-2 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-blue-600 to-indigo-500">
            <i class="fas fa-calendar-day mr-1"></i> {{ now()->format('d M Y') }}
          </span>
        </div>
      </div>
    </div>

    <!-- Stat Cards -->
    <div id="tour-stats" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
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
        <span class="text-xs text-slate-400">
          <i class="fas fa-circle text-green-500 mr-1" style="font-size: 6px; vertical-align: middle;"></i>
          {{ $employeeStatusCounts->active ?? 0 }} active
          <span class="mx-1">·</span>
          <i class="fas fa-circle text-red-400 mr-1" style="font-size: 6px; vertical-align: middle;"></i>
          {{ $employeeStatusCounts->inactive ?? 0 }} inactive
        </span>
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

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="mb-0 text-xs font-semibold text-slate-400">PENDING LEAVES</p>
          <p class="text-2xl font-bold text-amber-600 mb-0">{{ $pendingLeaves }}</p>
        </div>
        <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-amber-500 to-yellow-400 flex items-center justify-center text-white shadow-lg">
          <i class="fas fa-hourglass-half"></i>
        </div>
      </div>
      <div class="mt-3 pt-3 border-t border-slate-100">
        <span class="text-xs text-slate-400"><i class="fas fa-clock text-amber-400 mr-1"></i> Awaiting approval</span>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="mb-0 text-xs font-semibold text-slate-400">PENDING REIMBURSEMENTS</p>
          <p class="text-2xl font-bold text-cyan-600 mb-0">{{ $pendingReimbursements }}</p>
        </div>
        <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-cyan-500 to-blue-400 flex items-center justify-center text-white shadow-lg">
          <i class="fas fa-receipt"></i>
        </div>
      </div>
      <div class="mt-3 pt-3 border-t border-slate-100">
        <span class="text-xs text-slate-400"><i class="fas fa-clock text-cyan-400 mr-1"></i> Awaiting approval</span>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="mb-0 text-xs font-semibold text-slate-400">TODAY ATTENDANCE</p>
          <p class="text-2xl font-bold text-slate-700 mb-0">{{ $todayPresent + $todayLate + $todayAbsent }}</p>
        </div>
        <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-teal-500 to-emerald-400 flex items-center justify-center text-white shadow-lg">
          <i class="fas fa-calendar-check"></i>
        </div>
      </div>
      <div class="mt-3 pt-3 border-t border-slate-100">
        <span class="text-xs text-slate-400">
          <i class="fas fa-circle text-green-500 mr-1" style="font-size: 6px; vertical-align: middle;"></i> {{ $todayPresent }}
          <span class="mx-1">·</span>
          <i class="fas fa-circle text-orange-400 mr-1" style="font-size: 6px; vertical-align: middle;"></i> {{ $todayLate }}
          <span class="mx-1">·</span>
          <i class="fas fa-circle text-red-400 mr-1" style="font-size: 6px; vertical-align: middle;"></i> {{ $todayAbsent }}
        </span>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
      <div class="flex items-center justify-between">
        <div>
          <p class="mb-0 text-xs font-semibold text-slate-400">PAYROLL THIS MONTH</p>
          <p class="text-2xl font-bold text-slate-700 mb-0">Rp {{ number_format($totalPayrollThisMonth, 0, ',', '.') }}</p>
        </div>
        <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-pink-500 to-rose-400 flex items-center justify-center text-white shadow-lg">
          <i class="fas fa-money-bill-wave"></i>
        </div>
      </div>
      <div class="mt-3 pt-3 border-t border-slate-100">
        <span class="text-xs text-slate-400">
          <i class="fas fa-check-circle text-green-500 mr-1"></i> {{ $paidPayrollCount }} paid
          <span class="mx-1">·</span>
          <i class="fas fa-clock text-amber-400 mr-1"></i> {{ $pendingPayrollCount }} pending
        </span>
      </div>
    </div>

    <!-- Charts Row 1: Monthly Attendance Trend + Department Distribution -->
    <div id="tour-charts" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4 md:col-span-1 lg:col-span-2 xl:col-span-2">
      <div class="flex items-center justify-between p-2 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-chart-line text-blue-500 mr-2"></i>Monthly Attendance Trend</h6>
      </div>
      <div class="flex-auto p-2">
        <canvas id="attendanceTrendChart" height="180"></canvas>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4 md:col-span-1 lg:col-span-1 xl:col-span-1">
      <div class="flex items-center justify-between p-2 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-users text-purple-500 mr-2"></i>Department Distribution</h6>
      </div>
      <div class="flex-auto p-2">
        <canvas id="departmentChart" height="180"></canvas>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4 md:col-span-1 lg:col-span-1 xl:col-span-1">
      <div class="flex items-center justify-between p-2 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-circle text-green-500 mr-2"></i>Today's Attendance</h6>
      </div>
      <div class="flex-auto p-2 flex items-center justify-center">
        <canvas id="todayAttendanceChart" height="180" class="max-h-48"></canvas>
      </div>
    </div>

    <!-- Charts Row 2: Leave Status + Payroll Trend -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4 md:col-span-1 lg:col-span-1 xl:col-span-1">
      <div class="flex items-center justify-between p-2 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-alt text-purple-500 mr-2"></i>Leave Status</h6>
      </div>
      <div class="flex-auto p-2 flex items-center justify-center">
        <canvas id="leaveStatusChart" height="180" class="max-h-48"></canvas>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4 md:col-span-1 lg:col-span-2 xl:col-span-2">
      <div class="flex items-center justify-between p-2 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-chart-bar text-pink-500 mr-2"></i>Monthly Payroll Total</h6>
      </div>
      <div class="flex-auto p-2">
        <canvas id="payrollTrendChart" height="180"></canvas>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4 md:col-span-1 lg:col-span-1 xl:col-span-1">
      <div class="flex items-center justify-between p-2 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-umbrella-beach text-teal-500 mr-2"></i>Quick Recap</h6>
      </div>
      <div class="flex-auto p-2 space-y-3">
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-sm">
              <i class="fas fa-calendar-check text-sm"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-slate-400 mb-0">Today Present</p>
              <p class="text-lg font-bold text-slate-700 mb-0">{{ $todayPresent }}</p>
            </div>
          </div>
          <span class="text-xs text-green-500 font-semibold">{{ $todayPresent > 0 ? round(($todayPresent / max($todayPresent + $todayLate + $todayAbsent, 1)) * 100) : 0 }}%</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-amber-500 to-yellow-400 flex items-center justify-center text-white shadow-sm">
              <i class="fas fa-hourglass-half text-sm"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-slate-400 mb-0">Pending Requests</p>
              <p class="text-lg font-bold text-slate-700 mb-0">{{ $pendingLeaves + $pendingReimbursements }}</p>
            </div>
          </div>
          <span class="text-xs text-amber-500 font-semibold">{{ $pendingLeaves }} leaves · {{ $pendingReimbursements }} reimb.</span>
        </div>
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-teal-500 to-emerald-400 flex items-center justify-center text-white shadow-sm">
              <i class="fas fa-umbrella-beach text-sm"></i>
            </div>
            <div>
              <p class="text-xs font-semibold text-slate-400 mb-0">Holidays This Month</p>
              <p class="text-lg font-bold text-slate-700 mb-0">{{ $holidaysThisMonth }}</p>
            </div>
          </div>
          <span class="text-xs text-teal-500 font-semibold">{{ now()->format('F Y') }}</span>
        </div>
      </div>
    </div>

    <!-- Recent Attendance -->
    <div id="tour-recent-attendance" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border md:col-span-1 lg:col-span-2 xl:col-span-1">
      <div class="flex items-center justify-between p-4 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-check text-green-500 mr-2"></i>Recent Attendance</h6>
        <a href="{{ route('admin.attendances.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
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
              @forelse($recentAttendances as $attendance)
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

    <!-- Recent Leaves -->
    <div id="tour-leaves-reimbursements" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border md:col-span-1 lg:col-span-2 xl:col-span-1">
      <div class="flex items-center justify-between p-4 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-alt text-purple-500 mr-2"></i>Recent Leave Requests</h6>
        <a href="{{ route('admin.leaves.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
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
              @forelse($recentLeaves as $leave)
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

    <!-- Recent Payrolls -->
    <div id="tour-payrolls" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border md:col-span-1 lg:col-span-2 xl:col-span-1">
      <div class="flex items-center justify-between p-4 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-money-bill-wave text-pink-500 mr-2"></i>Recent Payrolls</h6>
        <a href="{{ route('admin.payrolls.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
      </div>
      <div class="flex-auto p-4">
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Amount</th>
                <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentPayrolls as $payroll)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $payroll->user->nama_lengkap ?? 'N/A' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs font-semibold text-slate-700">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
                    @if($payroll->status_pembayaran == 'paid') bg-gradient-to-tl from-green-600 to-lime-400
                    @else bg-gradient-to-tl from-amber-500 to-yellow-400 @endif">
                    {{ strtoupper($payroll->status_pembayaran) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="p-4 text-center text-slate-400">No payroll records</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <!-- Recent Reimbursements -->
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border md:col-span-1 lg:col-span-2 xl:col-span-1">
      <div class="flex items-center justify-between p-4 pb-0">
        <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-receipt text-cyan-500 mr-2"></i>Recent Reimbursements</h6>
        <a href="{{ route('admin.reimbursements.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
      </div>
      <div class="flex-auto p-4">
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Amount</th>
                <th class="px-4 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($recentReimbursements as $reimb)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $reimb->user->nama_lengkap ?? 'N/A' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs font-semibold text-slate-700">Rp {{ number_format($reimb->jumlah, 0, ',', '.') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
                    @if($reimb->status == 'approved') bg-gradient-to-tl from-green-600 to-lime-400
                    @elseif($reimb->status == 'pending') bg-gradient-to-tl from-purple-600 to-pink-500
                    @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
                    {{ strtoupper($reimb->status) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="3" class="p-4 text-center text-slate-400">No reimbursements</td>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const colors = {
    present: '#22c55e',
    late: '#f97316',
    absent: '#ef4444',
    approved: '#22c55e',
    pending: '#a855f7',
    rejected: '#ef4444',
    blue: '#3b82f6',
    indigo: '#6366f1',
    purple: '#a855f7',
    pink: '#ec4899',
    teal: '#14b8a6',
    cyan: '#06b6d4',
  };

  const chartDefaults = {
    responsive: true,
    maintainAspectRatio: true,
    plugins: {
      legend: {
        labels: {
          boxWidth: 8,
          padding: 8,
          font: { size: 10, family: 'Open Sans' }
        }
      }
    }
  };

  // 1. Monthly Attendance Trend (Line)
  const attCtx = document.getElementById('attendanceTrendChart');
  if (attCtx) {
    new Chart(attCtx, {
      type: 'line',
      data: {
        labels: {!! json_encode($months) !!},
        datasets: [
          {
            label: 'Present',
            data: {!! json_encode($attendanceMonthly->pluck('present')) !!},
            borderColor: colors.present,
            backgroundColor: colors.present + '20',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            borderWidth: 2
          },
          {
            label: 'Late',
            data: {!! json_encode($attendanceMonthly->pluck('late')) !!},
            borderColor: colors.late,
            backgroundColor: colors.late + '20',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            borderWidth: 2
          },
          {
            label: 'Absent',
            data: {!! json_encode($attendanceMonthly->pluck('absent')) !!},
            borderColor: colors.absent,
            backgroundColor: colors.absent + '20',
            fill: true,
            tension: 0.4,
            pointRadius: 3,
            borderWidth: 2
          }
        ]
      },
      options: {
        ...chartDefaults,
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } } },
          x: { ticks: { font: { size: 10 } } }
        }
      }
    });
  }

  // 2. Department Distribution (Bar)
  const deptCtx = document.getElementById('departmentChart');
  if (deptCtx) {
    new Chart(deptCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($departmentLabels) !!},
        datasets: [{
          label: 'Employees',
          data: {!! json_encode($departmentCounts) !!},
          backgroundColor: [
            '#3b82f6', '#6366f1', '#a855f7', '#ec4899',
            '#14b8a6', '#f97316', '#84cc16', '#06b6d4',
            '#8b5cf6', '#f43f5e'
          ],
          borderRadius: 4,
          borderSkipped: false
        }]
      },
      options: {
        ...chartDefaults,
        plugins: { legend: { display: false } },
        scales: {
          y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 10 } } },
          x: { ticks: { font: { size: 9 }, maxRotation: 45 } }
        }
      }
    });
  }

  // 3. Today's Attendance (Doughnut)
  const todayCtx = document.getElementById('todayAttendanceChart');
  if (todayCtx) {
    new Chart(todayCtx, {
      type: 'doughnut',
      data: {
        labels: ['Present', 'Late', 'Absent'],
        datasets: [{
          data: [{{ $todayPresent }}, {{ $todayLate }}, {{ $todayAbsent }}],
          backgroundColor: [colors.present, colors.late, colors.absent],
          borderWidth: 0
        }]
      },
      options: {
        ...chartDefaults,
        cutout: '65%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: { padding: 6, font: { size: 10 } }
          }
        }
      }
    });
  }

  // 4. Leave Status (Doughnut)
  const leaveCtx = document.getElementById('leaveStatusChart');
  if (leaveCtx) {
    new Chart(leaveCtx, {
      type: 'doughnut',
      data: {
        labels: ['Approved', 'Pending', 'Rejected'],
        datasets: [{
          data: [{{ $leaveStatuses['approved'] }}, {{ $leaveStatuses['pending'] }}, {{ $leaveStatuses['rejected'] }}],
          backgroundColor: [colors.approved, colors.pending, colors.rejected],
          borderWidth: 0
        }]
      },
      options: {
        ...chartDefaults,
        cutout: '65%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: { padding: 6, font: { size: 10 } }
          }
        }
      }
    });
  }

  // 5. Payroll Trend (Bar)
  const payrollCtx = document.getElementById('payrollTrendChart');
  if (payrollCtx) {
    new Chart(payrollCtx, {
      type: 'bar',
      data: {
        labels: {!! json_encode($payrollMonthly->pluck('month')) !!},
        datasets: [{
          label: 'Total Payroll (Rp)',
          data: {!! json_encode($payrollMonthly->pluck('total')) !!},
          backgroundColor: '#a855f7',
          borderRadius: 4,
          borderSkipped: false
        }]
      },
      options: {
        ...chartDefaults,
        plugins: { legend: { display: false } },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              font: { size: 10 },
              callback: function(value) {
                if (value >= 1000000) return 'Rp' + (value / 1000000).toFixed(0) + 'M';
                if (value >= 1000) return 'Rp' + (value / 1000).toFixed(0) + 'K';
                return 'Rp' + value;
              }
            }
          },
          x: { ticks: { font: { size: 10 } } }
        }
      }
    });
  }
});
</script>
@endpush
