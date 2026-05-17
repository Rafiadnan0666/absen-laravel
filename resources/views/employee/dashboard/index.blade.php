@extends('layouts.employee')

@section('page-title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-black mb-6 border-b-3 border-black pb-4">MY DASHBOARD</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="neo-card">
            <p class="neo-label">Today's Status</p>
            @if($todayAttendance)
                @if($todayAttendance->status_hadir == 'present')
                    <p class="text-2xl font-black text-neo-green">PRESENT</p>
                @elseif($todayAttendance->status_hadir == 'late')
                    <p class="text-2xl font-black text-neo-orange">LATE</p>
                @else
                    <p class="text-2xl font-black text-neo-red">ABSENT</p>
                @endif
            @else
                <p class="text-lg font-bold">NOT CHECKED IN</p>
            @endif
        </div>

        <div class="neo-card-yellow">
            <p class="neo-label">Today's Shift</p>
            <p class="text-2xl font-black">{{ $userShift ? $userShift->shift->nama_shift : 'No Shift' }}</p>
        </div>

        <div class="neo-card-pink">
            <p class="neo-label">Salary</p>
            <p class="text-2xl font-black">Rp {{ number_format($user->jumlah_gaji, 0, ',', '.') }}</p>
        </div>

        <div class="neo-card-cyan">
            <p class="neo-label">Department</p>
            <p class="text-xl font-bold">{{ $user->department->nama_department ?? '-' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="neo-card">
            <h2 class="font-black text-lg mb-4 border-b-3 border-black pb-2">Today's Attendance</h2>
            @if($todayAttendance)
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Status</p>
                        @if($todayAttendance->status_hadir == 'present')
                            <span class="neo-badge neo-badge-green">PRESENT</span>
                        @elseif($todayAttendance->status_hadir == 'late')
                            <span class="neo-badge neo-badge-yellow">LATE</span>
                        @else
                            <span class="neo-badge neo-badge-red">ABSENT</span>
                        @endif
                    </div>
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Check In</p>
                        <p class="font-black">{{ $todayAttendance->check_in ?? 'Not yet' }}</p>
                    </div>
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Check Out</p>
                        <p class="font-black">{{ $todayAttendance->check_out ?? 'Not yet' }}</p>
                    </div>
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Work Hours</p>
                        <p class="font-black">{{ $todayAttendance->jam_kerja ?? '-' }}</p>
                    </div>
                    @if($todayAttendance->menit_telat > 0)
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Late</p>
                        <p class="font-black text-neo-red">{{ $todayAttendance->menit_telat }} min</p>
                    </div>
                    @endif
                    @if($todayAttendance->jam_lembur)
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Overtime</p>
                        <p class="font-black">{{ $todayAttendance->jam_lembur }}</p>
                    </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8">
                    <p class="font-bold mb-4">No attendance recorded today</p>
                    <a href="{{ route('employee.attendances.create') }}" class="neo-btn-primary">CHECK IN NOW</a>
                </div>
            @endif
        </div>

        <div class="neo-card-yellow">
            <h2 class="font-black text-lg mb-4 border-b-3 border-black pb-2">My Info</h2>
            <ul class="space-y-2 text-sm">
                <li><strong>Name:</strong> {{ $user->nama_lengkap }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Phone:</strong> {{ $user->no_hp ?? '-' }}</li>
                <li><strong>Job Title:</strong> {{ $user->jobTitle->nama_jabatan ?? '-' }}</li>
                <li><strong>Salary Type:</strong> {{ strtoupper($user->tipe_gaji) }}</li>
                <li><strong>Join Date:</strong> {{ $user->tanggal_masuk->format('d M Y') }}</li>
                <li><strong>Status:</strong> <span class="neo-badge neo-badge-green">{{ strtoupper($user->status_akun) }}</span></li>
            </ul>
        </div>
    </div>

    @if($userShift)
    <div class="neo-card-cyan mb-6">
        <h2 class="font-black text-lg mb-4 border-b-3 border-black pb-2">Today's Shift</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 border-3 border-black text-center">
                <p class="neo-label">Shift</p>
                <p class="text-xl font-black">{{ $userShift->shift->nama_shift }}</p>
            </div>
            <div class="p-4 border-3 border-black text-center">
                <p class="neo-label">Start</p>
                <p class="text-xl font-black">{{ $userShift->shift->jam_masuk }}</p>
            </div>
            <div class="p-4 border-3 border-black text-center">
                <p class="neo-label">End</p>
                <p class="text-xl font-black">{{ $userShift->shift->jam_pulang }}</p>
            </div>
            <div class="p-4 border-3 border-black text-center">
                <p class="neo-label">Tolerance</p>
                <p class="text-xl font-black">{{ $userShift->shift->toleransi_telat_menit }} min</p>
            </div>
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="neo-card">
            <div class="flex justify-between items-center mb-4 border-b-3 border-black pb-2">
                <h2 class="font-black text-lg">Recent Attendance</h2>
                <a href="{{ route('employee.attendances.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
            </div>
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr><th>Date</th><th>Check In</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($recentAttendances as $item)
                        <tr>
                            <td class="font-bold">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                            <td>{{ $item->check_in ?? '-' }}</td>
                            <td>
                                @if($item->status_hadir == 'present')
                                    <span class="neo-badge neo-badge-green">PRESENT</span>
                                @elseif($item->status_hadir == 'late')
                                    <span class="neo-badge neo-badge-yellow">LATE</span>
                                @else
                                    <span class="neo-badge neo-badge-red">ABSENT</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-8 font-bold">No records</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="neo-card-purple">
            <div class="flex justify-between items-center mb-4 border-b-3 border-black pb-2">
                <h2 class="font-black text-lg">My Leaves</h2>
                <a href="{{ route('employee.leaves.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
            </div>
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr><th>Type</th><th>Period</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $item)
                        <tr>
                            <td><span class="neo-badge neo-badge-cyan">{{ strtoupper($item->tipe_cuti) }}</span></td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                            <td>
                                @if($item->status_pengajuan == 'approved')
                                    <span class="neo-badge neo-badge-green">{{ strtoupper($item->status_pengajuan) }}</span>
                                @elseif($item->status_pengajuan == 'pending')
                                    <span class="neo-badge neo-badge-yellow">{{ strtoupper($item->status_pengajuan) }}</span>
                                @else
                                    <span class="neo-badge neo-badge-red">{{ strtoupper($item->status_pengajuan) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="3" class="text-center py-8 font-bold">No records</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection