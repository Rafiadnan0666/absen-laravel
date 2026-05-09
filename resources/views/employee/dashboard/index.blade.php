@extends('layouts.employee')

@section('page-title', 'Dashboard')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">My Dashboard</h1>

    <!-- Stats Cards Row -->
    <div class="flex flex-wrap -mx-3 mb-6">
        <!-- Today's Attendance Status -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Today's Status</p>
                                <h5 class="mb-0 font-bold text-slate-700">
                                    @if($todayAttendance)
                                        <span class="text-sm font-weight-bolder 
                                            @if($todayAttendance->status_hadir == 'present') text-green-500
                                            @elseif($todayAttendance->status_hadir == 'late') text-yellow-500
                                            @else text-red-500 @endif">
                                            {{ strtoupper($todayAttendance->status_hadir) }}
                                        </span>
                                    @else
                                        <span class="text-sm text-gray-400">NOT CHECKED IN</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-green-600 to-lime-400">
                                <i class="fas fa-check text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shift Info -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Today's Shift</p>
                                <h5 class="mb-0 font-bold text-slate-700">
                                    @if($userShift)
                                        {{ $userShift->shift->nama_shift }}
                                    @else
                                        <span class="text-sm text-gray-400">No Shift</span>
                                    @endif
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-blue-600 to-cyan-400">
                                <i class="fas fa-clock text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Attendance -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Salary</p>
                                <h5 class="mb-0 font-bold text-slate-700 text-sm">
                                    Rp {{ number_format($user->jumlah_gaji, 0, ',', '.') }}
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-red-600 to-rose-400">
                                <i class="fas fa-money-bill text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Department -->
        <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="flex-auto p-4">
                    <div class="flex flex-row -mx-3">
                        <div class="flex-none w-2/3 max-w-full px-3">
                            <div>
                                <p class="mb-0 font-sans font-semibold leading-normal text-sm">Department</p>
                                <h5 class="mb-0 font-bold text-slate-700 text-sm">
                                    {{ $user->department->nama_department ?? '-' }}
                                </h5>
                            </div>
                        </div>
                        <div class="px-3 text-right basis-1/3">
                            <div class="inline-block w-12 h-12 text-center rounded-lg bg-gradient-to-tl from-slate-600 to-slate-300">
                                <i class="fas fa-building text-lg relative top-3.5 text-white"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Attendance Detail & My Info -->
    <div class="flex flex-wrap -mx-3 mb-6">
        <!-- Today's Attendance -->
        <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-bold text-slate-700">Today's Attendance</h6>
                </div>
                <div class="flex-auto p-4">
                    @if($todayAttendance)
                        <div class="relative w-full px-5 py-5 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="leading-tight text-sm text-slate-400">Status</p>
                                    <h6 class="mb-1 font-bold text-slate-700">
                                        <span class="badge bg-gradient-to-tl from-green-600 to-lime-400 py-1 px-2 text-xs rounded-lg text-white">
                                            {{ strtoupper($todayAttendance->status_hadir) }}
                                        </span>
                                    </h6>
                                </div>
                                <div>
                                    <p class="leading-tight text-sm text-slate-400">Check In</p>
                                    <h6 class="mb-1 font-bold text-slate-700">{{ $todayAttendance->check_in ?? 'Not yet' }}</h6>
                                </div>
                                <div>
                                    <p class="leading-tight text-sm text-slate-400">Check Out</p>
                                    <h6 class="mb-1 font-bold text-slate-700">{{ $todayAttendance->check_out ?? 'Not yet' }}</h6>
                                </div>
                                <div>
                                    <p class="leading-tight text-sm text-slate-400">Work Hours</p>
                                    <h6 class="mb-1 font-bold text-slate-700">{{ $todayAttendance->jam_kerja ?? '-' }}</h6>
                                </div>
                                @if($todayAttendance->menit_telat > 0)
                                    <div>
                                        <p class="leading-tight text-sm text-slate-400">Late</p>
                                        <h6 class="mb-1 font-bold text-red-500">{{ $todayAttendance->menit_telat }} minutes</h6>
                                    </div>
                                @endif
                                @if($todayAttendance->jam_lembur)
                                    <div>
                                        <p class="leading-tight text-sm text-slate-400">Overtime</p>
                                        <h6 class="mb-1 font-bold text-blue-500">{{ $todayAttendance->jam_lembur }}</h6>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-slate-400 mb-4">No attendance recorded today</p>
                            <a href="{{ route('employee.attendances.create') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-green-600 to-lime-400 leading-pro text-xs ease-soft-in tracking-tight-soft hover:bg-gray-100">
                                Check In Now
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- My Info -->
        <div class="w-full max-w-full px-3 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-bold text-slate-700">My Info</h6>
                </div>
                <div class="flex-auto p-4">
                    <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                        <li class="relative block px-4 py-2 pt-0 pl-0 leading-normal bg-white border-0 border-t-0 border-solid text-sm">
                            <strong class="text-slate-700">Name:</strong> {{ $user->nama_lengkap }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 border-solid text-sm">
                            <strong class="text-slate-700">Email:</strong> {{ $user->email }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 border-solid text-sm">
                            <strong class="text-slate-700">Phone:</strong> {{ $user->no_hp ?? '-' }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 border-solid text-sm">
                            <strong class="text-slate-700">Job Title:</strong> {{ $user->jobTitle->nama_jabatan ?? '-' }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 border-solid text-sm">
                            <strong class="text-slate-700">Salary Type:</strong> {{ strtoupper($user->tipe_gaji) }}
                        </li>
                        <li class="relative block px-4 py-2 pl-0 leading-normal bg-white border-0 border-t-0 border-solid text-sm">
                            <strong class="text-slate-700">Join Date:</strong> {{ $user->tanggal_masuk->format('d M Y') }}
                        </li>
                        <li class="relative block px-4 py-2 pb-0 pl-0 leading-normal bg-white border-0 border-t-0 border-solid text-sm">
                            <strong class="text-slate-700">Status:</strong> 
                            <span class="badge bg-gradient-to-tl from-green-600 to-lime-400 py-1 px-2 text-xs rounded-lg text-white">
                                {{ strtoupper($user->status_akun) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Today's Shift -->
    @if($userShift)
    <div class="flex flex-wrap -mx-3 mb-6">
        <div class="w-full max-w-full px-3">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <h6 class="mb-0 font-bold text-slate-700">Today's Shift</h6>
                </div>
                <div class="flex-auto p-4">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">Shift</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->nama_shift }}</h6>
                        </div>
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">Start</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->jam_masuk }}</h6>
                        </div>
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">End</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->jam_pulang }}</h6>
                        </div>
                        <div class="relative w-full px-3 py-3 mx-auto overflow-hidden bg-white border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border text-center">
                            <p class="leading-tight text-sm text-slate-400">Tolerance</p>
                            <h6 class="mb-1 font-bold text-slate-700">{{ $userShift->shift->toleransi_telat_menit }} min</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Attendance & My Leaves -->
    <div class="flex flex-wrap -mx-3">
        <!-- Recent Attendance -->
        <div class="w-full max-w-full px-3 mb-6 lg:mb-0 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex justify-between items-center">
                        <h6 class="mb-0 font-bold text-slate-700">Recent Attendance</h6>
                        <a href="{{ route('employee.attendances.index') }}" class="text-sm font-semibold text-blue-500 hover:text-blue-600">View All</a>
                    </div>
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
                                        <span class="badge bg-gradient-to-tl 
                                            @if($item->status_hadir == 'present') from-green-600 to-lime-400
                                            @elseif($item->status_hadir == 'late') from-yellow-600 to-orange-400
                                            @else from-red-600 to-rose-400 @endif py-1 px-2 text-xs rounded-lg text-white">
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
        </div>

        <!-- My Leaves -->
        <div class="w-full max-w-full px-3 lg:w-1/2">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
                <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
                    <div class="flex justify-between items-center">
                        <h6 class="mb-0 font-bold text-slate-700">My Leaves</h6>
                        <a href="{{ route('employee.leaves.index') }}" class="text-sm font-semibold text-blue-500 hover:text-blue-600">View All</a>
                    </div>
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
                                        <span class="badge bg-gradient-to-tl from-blue-600 to-cyan-400 py-1 px-2 text-xs rounded-lg text-white">
                                            {{ strtoupper($item->tipe_cuti) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-slate-500">{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                                    <td class="px-4 py-3">
                                        <span class="badge bg-gradient-to-tl 
                                            @if($item->status_pengajuan == 'approved') from-green-600 to-lime-400
                                            @elseif($item->status_pengajuan == 'pending') from-yellow-600 to-orange-400
                                            @else from-red-600 to-rose-400 @endif py-1 px-2 text-xs rounded-lg text-white">
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
    </div>
@endsection
