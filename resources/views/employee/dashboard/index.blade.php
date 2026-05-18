@extends('layouts.employee')

@section('page-title', 'Dashboard')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-4xl font-black text-slate-700">Dashboard</h1>
            <p class="text-slate-400">Welcome back, {{ $user->nama_lengkap }}</p>
        </div>
        @if(!$todayAttendance)
            <a href="{{ route('employee.attendances.create') }}" class="px-6 py-3 font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all text-xs flex items-center gap-2">
                <i class="fas fa-fingerprint"></i> Check In Now
            </a>
        @endif
    </div>

    <!-- Stats Cards - 4 col grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="mb-0 text-xs font-semibold text-slate-400">Today's Status</p>
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 flex items-center justify-center text-white text-sm shadow-lg">
                    <i class="fas fa-check"></i>
                </div>
            </div>
            <h5 class="mb-0 font-bold text-slate-700">
                @if($todayAttendance)
                    <span class="text-lg
                        @if($todayAttendance->status_hadir == 'present') text-green-500
                        @elseif($todayAttendance->status_hadir == 'late') text-blue-500
                        @else text-red-500 @endif">
                        {{ strtoupper($todayAttendance->status_hadir) }}
                    </span>
                @else
                    <span class="text-sm text-gray-400">NOT CHECKED IN</span>
                @endif
            </h5>
        </div>

        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="mb-0 text-xs font-semibold text-slate-400">Today's Shift</p>
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400 flex items-center justify-center text-white text-sm shadow-lg">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
            <h5 class="mb-0 font-bold text-slate-700">
                @if($userShift)
                    {{ $userShift->shift->nama_shift }}
                @else
                    <span class="text-sm text-gray-400">No Shift</span>
                @endif
            </h5>
        </div>

        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="mb-0 text-xs font-semibold text-slate-400">Salary</p>
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-red-600 to-rose-400 flex items-center justify-center text-white text-sm shadow-lg">
                    <i class="fas fa-money-bill"></i>
                </div>
            </div>
            <h5 class="mb-0 font-bold text-slate-700 text-sm">Rp {{ number_format($user->jumlah_gaji, 0, ',', '.') }}</h5>
        </div>

        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border p-4">
            <div class="flex items-center justify-between mb-2">
                <p class="mb-0 text-xs font-semibold text-slate-400">Department</p>
                <div class="w-10 h-10 rounded-lg bg-gradient-to-tl from-slate-600 to-slate-300 flex items-center justify-center text-white text-sm shadow-lg">
                    <i class="fas fa-building"></i>
                </div>
            </div>
            <h5 class="mb-0 font-bold text-slate-700 text-sm">{{ $user->department->nama_department ?? '-' }}</h5>
        </div>
    </div>

    <!-- Middle: Attendance Detail (col) + My Info (col) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Today's Attendance Detail (column layout) -->
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex items-center justify-between p-4 pb-0">
                <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-day text-green-500 mr-2"></i>Today's Attendance</h6>
            </div>
            <div class="flex-auto p-4">
                @if($todayAttendance)
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-xs text-slate-400 mb-1">Status</p>
                            <h6 class="mb-0 font-bold text-slate-700">
                                <span class="px-3 py-1 text-xs rounded-lg text-white bg-gradient-to-tl from-green-600 to-lime-400">
                                    {{ strtoupper($todayAttendance->status_hadir) }}
                                </span>
                            </h6>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-xs text-slate-400 mb-1">Check In</p>
                            <h6 class="mb-0 font-bold text-slate-700">{{ $todayAttendance->check_in ?? 'Not yet' }}</h6>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-xs text-slate-400 mb-1">Check Out</p>
                            <h6 class="mb-0 font-bold text-slate-700">{{ $todayAttendance->check_out ?? 'Not yet' }}</h6>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-3">
                            <p class="text-xs text-slate-400 mb-1">Work Hours</p>
                            <h6 class="mb-0 font-bold text-slate-700">{{ $todayAttendance->jam_kerja ?? '-' }}</h6>
                        </div>
                        @if($todayAttendance->menit_telat > 0)
                            <div class="bg-red-50 rounded-xl p-3">
                                <p class="text-xs text-slate-400 mb-1">Late</p>
                                <h6 class="mb-0 font-bold text-red-500">{{ $todayAttendance->menit_telat }} minutes</h6>
                            </div>
                        @endif
                        @if($todayAttendance->jam_lembur)
                            <div class="bg-blue-50 rounded-xl p-3">
                                <p class="text-xs text-slate-400 mb-1">Overtime</p>
                                <h6 class="mb-0 font-bold text-blue-500">{{ $todayAttendance->jam_lembur }}</h6>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center py-8">
                        <p class="text-slate-400 mb-4">No attendance recorded today</p>
                        <a href="{{ route('employee.attendances.create') }}" class="px-6 py-2 font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all text-xs">
                            Check In Now
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- My Info (column layout) -->
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex items-center justify-between p-4 pb-0">
                <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-user-circle text-blue-500 mr-2"></i>My Info</h6>
            </div>
            <div class="flex-auto p-4">
                <div class="space-y-2">
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs text-slate-400">Name</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $user->nama_lengkap }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs text-slate-400">Email</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $user->email }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs text-slate-400">Phone</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $user->no_hp ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs text-slate-400">Job Title</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $user->jobTitle->nama_jabatan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs text-slate-400">Salary Type</span>
                        <span class="text-sm font-semibold text-slate-700">{{ strtoupper($user->tipe_gaji) }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs text-slate-400">Join Date</span>
                        <span class="text-sm font-semibold text-slate-700">{{ $user->tanggal_masuk->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between items-center p-3 bg-slate-50 rounded-xl">
                        <span class="text-xs text-slate-400">Status</span>
                        <span class="px-3 py-1 text-xs rounded-lg text-white bg-gradient-to-tl from-green-600 to-lime-400">{{ strtoupper($user->status_akun) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Shift Info (full width row) -->
    @if($userShift)
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
        <div class="flex items-center justify-between p-4 pb-0">
            <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-clock text-blue-500 mr-2"></i>Today's Shift</h6>
        </div>
        <div class="flex-auto p-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-slate-400 mb-1">Shift</p>
                    <h6 class="mb-0 font-bold text-slate-700">{{ $userShift->shift->nama_shift }}</h6>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-slate-400 mb-1">Start</p>
                    <h6 class="mb-0 font-bold text-slate-700">{{ $userShift->shift->jam_masuk }}</h6>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-slate-400 mb-1">End</p>
                    <h6 class="mb-0 font-bold text-slate-700">{{ $userShift->shift->jam_pulang }}</h6>
                </div>
                <div class="bg-slate-50 rounded-xl p-4 text-center">
                    <p class="text-xs text-slate-400 mb-1">Tolerance</p>
                    <h6 class="mb-0 font-bold text-slate-700">{{ $userShift->shift->toleransi_telat_menit }} min</h6>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Tables Row: Recent Attendance (col) + My Leaves (col) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Attendance -->
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex items-center justify-between p-4 pb-0">
                <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-history text-green-500 mr-2"></i>Recent Attendance</h6>
                <a href="{{ route('employee.attendances.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
            </div>
            <div class="flex-auto p-4">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Date</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Check In</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentAttendances as $item)
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3 text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                                <td class="px-4 py-3 text-sm text-slate-500">{{ $item->check_in ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl 
                                        @if($item->status_hadir == 'present') from-green-600 to-lime-400
                                        @elseif($item->status_hadir == 'late') from-blue-600 to-indigo-500
                                        @else from-red-600 to-rose-400 @endif">
                                        {{ strtoupper($item->status_hadir) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-400">No attendance records</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- My Leaves -->
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
            <div class="flex items-center justify-between p-4 pb-0">
                <h6 class="mb-0 font-bold text-slate-700"><i class="fas fa-calendar-alt text-purple-500 mr-2"></i>My Leaves</h6>
                <a href="{{ route('employee.leaves.index') }}" class="text-xs font-semibold text-blue-500 hover:text-blue-600">View All →</a>
            </div>
            <div class="flex-auto p-4">
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Period</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leaves as $item)
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3 text-sm">
                                    <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl from-blue-600 to-cyan-400">
                                        {{ strtoupper($item->tipe_cuti) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm text-slate-500">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-1 text-xs rounded-lg text-white bg-gradient-to-tl 
                                        @if($item->status_pengajuan == 'approved') from-green-600 to-lime-400
                                        @elseif($item->status_pengajuan == 'pending') from-blue-600 to-indigo-500
                                        @else from-red-600 to-rose-400 @endif">
                                        {{ strtoupper($item->status_pengajuan) }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-4 py-8 text-center text-slate-400">No leave records</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
