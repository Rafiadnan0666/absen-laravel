@extends('hr.dashboard.layout')

@section('page-title', 'HR Dashboard')

@section('content')
    <h1 class="neo-section-title">HR DASHBOARD</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="neo-card neo-card-green">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase">Today's Attendance</p>
                    <p class="text-4xl font-black">{{ $todayAttendances->count() }}</p>
                    <p class="text-sm">Employees</p>
                </div>
            </div>
        </div>

        <div class="neo-card neo-card-yellow">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase">Pending Leaves</p>
                    <p class="text-4xl font-black">{{ $pendingLeaves->count() }}</p>
                    <p class="text-sm">Requests</p>
                </div>
            </div>
        </div>

        <div class="neo-card neo-card-cyan">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase">Pending Reimbursements</p>
                    <p class="text-4xl font-black">{{ $pendingReimbursements->count() }}</p>
                    <p class="text-sm">Requests</p>
                </div>
            </div>
        </div>
    </div>

    <div class="neo-card mb-6">
        <div class="flex justify-between items-center mb-4 p-4 border-b-4 border-black">
            <h2 class="font-black text-xl">Today's Attendance</h2>
            <a href="{{ route('hr.attendances.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
        </div>
        <div class="p-4">
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Check In</th>
                            <th>Check Out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($todayAttendances as $attendance)
                        <tr>
                            <td class="font-bold">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ $attendance->check_in ?? '-' }}</td>
                            <td>{{ $attendance->check_out ?? '-' }}</td>
                            <td>
                                @if($attendance->status_hadir == 'present')
                                    <span class="neo-badge neo-badge-green">PRESENT</span>
                                @elseif($attendance->status_hadir == 'late')
                                    <span class="neo-badge neo-badge-yellow">LATE</span>
                                @else
                                    <span class="neo-badge neo-badge-red">ABSENT</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-8 font-bold">No attendance today</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="neo-card neo-card-yellow">
            <div class="flex justify-between items-center mb-4 p-4 border-b-4 border-black">
                <h2 class="font-black text-lg">Pending Leaves</h2>
                <a href="{{ route('hr.leaves.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
            </div>
            <div class="p-4">
                <div class="neo-table-container">
                    <table class="neo-table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Type</th>
                                <th>Period</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingLeaves as $leave)
                            <tr>
                                <td class="font-bold">{{ $leave->user->nama_lengkap ?? 'N/A' }}</td>
                                <td><span class="neo-label">{{ strtoupper($leave->tipe_cuti) }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
                                <td>
                                    <form action="{{ route('hr.leaves.approve', $leave) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn-primary neo-btn-sm">✓</button>
                                    </form>
                                    <form action="{{ route('hr.leaves.reject', $leave) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn-danger neo-btn-sm">✗</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-8 font-bold">No pending leaves</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="neo-card neo-card-cyan">
            <div class="flex justify-between items-center mb-4 p-4 border-b-4 border-black">
                <h2 class="font-black text-lg">Pending Reimbursements</h2>
                <a href="{{ route('hr.reimbursements.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
            </div>
            <div class="p-4">
                <div class="neo-table-container">
                    <table class="neo-table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Category</th>
                                <th>Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingReimbursements as $reimbursement)
                            <tr>
                                <td class="font-bold">{{ $reimbursement->user->nama_lengkap ?? 'N/A' }}</td>
                                <td><span class="neo-label">{{ strtoupper($reimbursement->kategori) }}</span></td>
                                <td class="font-bold">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('hr.reimbursements.approve', $reimbursement) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn-primary neo-btn-sm">✓</button>
                                    </form>
                                    <form action="{{ route('hr.reimbursements.reject', $reimbursement) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn-danger neo-btn-sm">✗</button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-8 font-bold">No pending reimbursements</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection