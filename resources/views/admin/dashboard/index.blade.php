@extends('admin.dashboard.layout')

@section('title', 'Admin Dashboard - ABS')

@section('content')
<h1 class="neo-section-title">ADMIN DASHBOARD</h1>

<div class="neo-card mb-6">
    <div class="mb-0">
        <p class="text-sm font-bold  mb-2">Welcome back,</p>
        <h1 class="text-3xl font-black mb-2">{{ auth()->user()->nama_lengkap }}</h1>
        <p class="text-sm font-bold">Here's what's happening with your ABS system today.</p>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="neo-card">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase  mb-2">TOTAL USERS</p>
                <p class="text-3xl font-black">{{ \App\Models\User::count() }}</p>
            </div>
            <div class="neo-avatar bg-neo-purple text-black">👥</div>
        </div>
    </div>

    <div class="neo-card-green">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase  mb-2">PRESENT TODAY</p>
                <p class="text-3xl font-black">{{ \App\Models\Attendance::whereDate('tanggal', today())->where('status_hadir', 'present')->count() }}</p>
            </div>
            <div class="neo-avatar bg-neo-green text-black">✅</div>
        </div>
    </div>

    <div class="neo-card-yellow">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase  mb-2">PENDING LEAVES</p>
                <p class="text-3xl font-black">{{ \App\Models\Leave::where('status_pengajuan', 'pending')->count() }}</p>
            </div>
            <div class="neo-avatar bg-neo-orange text-black">🏖️</div>
        </div>
    </div>

    <div class="neo-card-pink">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase  mb-2">PENDING REIMBURSEMENTS</p>
                <p class="text-3xl font-black">{{ \App\Models\Reimbursement::where('status', 'pending')->count() }}</p>
            </div>
            <div class="neo-avatar bg-neo-red text-black">💰</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="neo-card">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">📊 Recent Attendance</h2>
        </div>
        <div class="neo-table-container">
            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Attendance::with('user')->latest('tanggal')->take(5)->get() as $attendance)
                    <tr>
                        <td class="font-bold">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</td>
                        <td class="text-sm">{{ $attendance->tanggal->format('d M Y') }}</td>
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
                    <tr><td colspan="3" class="text-center py-4 font-bold">No records</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="neo-card-yellow">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">🏖️ Recent Leave Requests</h2>
        </div>
        <div class="neo-table-container">
            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Type</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\App\Models\Leave::with('user')->latest('tanggal_mulai')->take(5)->get() as $leave)
                    <tr>
                        <td class="font-bold">{{ $leave->user->nama_lengkap ?? 'N/A' }}</td>
                        <td><span class="neo-badge neo-badge-cyan">{{ ucfirst($leave->tipe_cuti) }}</span></td>
                        <td>
                            @if($leave->status_pengajuan == 'approved')
                                <span class="neo-badge neo-badge-green">{{ strtoupper($leave->status_pengajuan) }}</span>
                            @elseif($leave->status_pengajuan == 'pending')
                                <span class="neo-badge neo-badge-yellow">{{ strtoupper($leave->status_pengajuan) }}</span>
                            @else
                                <span class="neo-badge neo-badge-red">{{ strtoupper($leave->status_pengajuan) }}</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" class="text-center py-4 font-bold">No requests</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection