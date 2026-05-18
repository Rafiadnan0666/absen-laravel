@extends('hr.dashboard.layout')

@section('page-title', 'HR Dashboard')

@section('content')
    <div id="tour-welcome" class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-black text-slate-700">HR Dashboard</h1>
            <p class="text-slate-400">Manage attendance, leaves & reimbursements</p>
        </div>
        <div class="flex gap-2">
            <span class="px-4 py-2 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                <i class="fas fa-check-circle mr-1"></i> {{ now()->format('d M Y') }}
            </span>
        </div>
    </div>

    <!-- Stats Cards - 3 col grid -->
    <div id="tour-stats" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="mb-0 text-xs font-semibold text-slate-400">Today's Attendance</p>
                <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h5 class="mb-0 font-bold text-slate-700 text-2xl">{{ $todayAttendances->count() }}</h5>
                <span class="text-xs text-slate-400">Employees</span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-400"><i class="fas fa-arrow-up text-green-500 mr-1"></i> Checked in today</span>
            </div>
        </div>

        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="mb-0 text-xs font-semibold text-slate-400">Pending Leaves</p>
                <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-blue-600 to-indigo-500 flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-calendar-times"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h5 class="mb-0 font-bold text-slate-700 text-2xl">{{ $pendingLeaves->count() }}</h5>
                <span class="text-xs text-slate-400">Requests</span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-400"><i class="fas fa-clock text-blue-400 mr-1"></i> Awaiting approval</span>
            </div>
        </div>

        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="mb-0 text-xs font-semibold text-slate-400">Pending Reimbursements</p>
                <div class="w-12 h-12 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center text-white shadow-lg">
                    <i class="fas fa-receipt"></i>
                </div>
            </div>
            <div class="flex items-baseline gap-2">
                <h5 class="mb-0 font-bold text-slate-700 text-2xl">{{ $pendingReimbursements->count() }}</h5>
                <span class="text-xs text-slate-400">Requests</span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100">
                <span class="text-xs text-slate-400"><i class="fas fa-clock text-blue-400 mr-1"></i> Awaiting approval</span>
            </div>
        </div>
    </div>

    <!-- Today's Attendance Table (full width row) -->
    <div id="tour-today-attendance" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
        <div class="flex items-center justify-between p-4 pb-0">
            <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-clipboard-list text-green-500 mr-2"></i>Today's Attendance</h6>
            <a href="{{ route('hr.attendances.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
        </div>
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Employee</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Check In</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Check Out</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayAttendances as $attendance)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-3 text-sm font-semibold text-slate-700">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $attendance->check_in ?? '-' }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ $attendance->check_out ?? '-' }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl 
                                    @if($attendance->status_hadir == 'present') from-green-600 to-lime-400
                                    @elseif($attendance->status_hadir == 'late') from-blue-600 to-indigo-500
                                    @else from-red-600 to-rose-400 @endif">
                                    {{ strtoupper($attendance->status_hadir) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-400">No attendance today</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pending Leaves & Reimbursements side by side (2 col) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Pending Leaves -->
        <div id="tour-pending-leaves" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex items-center justify-between p-4 pb-0">
                <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-alt text-purple-500 mr-2"></i>Pending Leaves</h6>
                <a href="{{ route('hr.leaves.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
            </div>
            <div class="flex-auto p-4">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Employee</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Period</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingLeaves as $leave)
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3 text-sm font-semibold text-slate-700">{{ $leave->user->nama_lengkap ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl from-blue-600 to-cyan-400">
                                        {{ strtoupper($leave->tipe_cuti) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
                                <td class="px-4 py-3 flex gap-1">
                                    <form action="{{ route('hr.leaves.approve', $leave) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all">✓</button>
                                    </form>
                                    <form action="{{ route('hr.leaves.reject', $leave) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 transition-all">✕</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-400">No pending leaves</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Pending Reimbursements -->
        <div id="tour-pending-reimbursements" class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex items-center justify-between p-4 pb-0">
                <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-receipt text-orange-500 mr-2"></i>Pending Reimbursements</h6>
                <a href="{{ route('hr.reimbursements.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
            </div>
            <div class="flex-auto p-4">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Employee</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Category</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Amount</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingReimbursements as $reimbursement)
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3 text-sm font-semibold text-slate-700">{{ $reimbursement->user->nama_lengkap ?? 'N/A' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl from-purple-600 to-pink-400">
                                        {{ strtoupper($reimbursement->kategori) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-slate-700">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 flex gap-1">
                                    <form action="{{ route('hr.reimbursements.approve', $reimbursement) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all">✓</button>
                                    </form>
                                    <form action="{{ route('hr.reimbursements.reject', $reimbursement) }}" method="POST">
                                        @csrf
                                        <button class="px-3 py-1 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 transition-all">✕</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-slate-400">No pending reimbursements</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
