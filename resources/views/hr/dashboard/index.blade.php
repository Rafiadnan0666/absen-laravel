@extends('hr.dashboard.layout')

@section('page-title', 'HR Dashboard')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">HR Dashboard</h1>

    <!-- Stats Cards Row -->
    <div class="flex flex-wrap -mx-3 mb-6">
        <!-- Today's Attendance -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Today's Attendance</p>
                                <h5 class="mb-0 font-bold text-slate-700">
                                    {{ $todayAttendances->count() }} Employees
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                <i class="fas fa-calendar-check text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Leaves -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Pending Leaves</p>
                                <h5 class="mb-0 font-bold text-slate-700">
                                    {{ $pendingLeaves->count() }} Requests
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-yellow-600 to-orange-400">
                                <i class="fas fa-calendar-times text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Reimbursements -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:w-1/3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Pending Reimbursements</p>
                                <h5 class="mb-0 font-bold text-slate-700">
                                    {{ $pendingReimbursements->count() }} Requests
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                <i class="fas fa-receipt text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance -->
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex justify-between items-center">
                        <h6 class="mb-0 font-bold text-slate-700">Today's Attendance</h6>
                        <a href="{{ route('hr.attendances.index') }}" class="text-sm font-semibold text-blue-500 hover:text-blue-600">View All</a>
                    </div>
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
                                        <span class="badge bg-gradient-to-tl 
                                            @if($attendance->status_hadir == 'present') from-green-600 to-lime-400
                                            @elseif($attendance->status_hadir == 'late') from-yellow-600 to-orange-400
                                            @else from-red-600 to-rose-400 @endif py-1 px-2 text-xs rounded-lg text-white">
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
        </div>
    </div>

    <!-- Pending Leaves & Reimbursements -->
    <div class="flex flex-wrap -mx-3">
        <!-- Pending Leaves -->
        <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex justify-between items-center">
                        <h6 class="mb-0 font-bold text-slate-700">Pending Leaves</h6>
                        <a href="{{ route('hr.leaves.index') }}" class="text-sm font-semibold text-blue-500 hover:text-blue-600">View All</a>
                    </div>
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
                                        <span class="badge bg-gradient-to-tl from-blue-600 to-cyan-400 py-1 px-2 text-xs rounded-lg text-white">
                                            {{ strtoupper($leave->tipe_cuti) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-500">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('hr.leaves.approve', $leave) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="inline-block px-4 py-1 mb-0 text-xs font-bold text-center text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all">Approve</button>
                                        </form>
                                        <form action="{{ route('hr.leaves.reject', $leave) }}" method="POST" class="inline ml-1">
                                            @csrf
                                            <button class="inline-block px-4 py-1 mb-0 text-xs font-bold text-center text-white uppercase rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 transition-all">Reject</button>
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
        </div>

        <!-- Pending Reimbursements -->
        <div class="w-full max-w-full px-3 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex justify-between items-center">
                        <h6 class="mb-0 font-bold text-slate-700">Pending Reimbursements</h6>
                        <a href="{{ route('hr.reimbursements.index') }}" class="text-sm font-semibold text-blue-500 hover:text-blue-600">View All</a>
                    </div>
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
                                        <span class="badge bg-gradient-to-tl from-purple-600 to-pink-400 py-1 px-2 text-xs rounded-lg text-white">
                                            {{ strtoupper($reimbursement->kategori) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-bold text-slate-700">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</td>
                                    <td class="px-4 py-3">
                                        <form action="{{ route('hr.reimbursements.approve', $reimbursement) }}" method="POST" class="inline">
                                            @csrf
                                            <button class="inline-block px-4 py-1 mb-0 text-xs font-bold text-center text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all">Approve</button>
                                        </form>
                                        <form action="{{ route('hr.reimbursements.reject', $reimbursement) }}" method="POST" class="inline ml-1">
                                            @csrf
                                            <button class="inline-block px-4 py-1 mb-0 text-xs font-bold text-center text-white uppercase rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 hover:scale-102 transition-all">Reject</button>
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
    </div>
@endsection
