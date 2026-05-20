@extends('layouts.employee')

@section('page-title', 'Dashboard')

@section('content')
    <h1 class="text-3xl font-black mb-6 border-b-3 border-black pb-4 fade-in-up">MY DASHBOARD</h1>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
        <div class="neo-card fade-in-up fade-in-up-d1">
            <p class="neo-label">Today's Status</p>
            @if($todayAttendance)
                @if($todayAttendance->status_hadir == 'present')
                    <p class="text-2xl font-black text-neo-green animate-pulse">✅ PRESENT</p>
                @elseif($todayAttendance->status_hadir == 'late')
                    <p class="text-2xl font-black text-neo-orange">⚠️ LATE</p>
                @elseif($todayAttendance->status_hadir == 'holiday')
                    <p class="text-2xl font-black text-neo-cyan">🎉 HOLIDAY</p>
                @else
                    <p class="text-2xl font-black text-neo-red">❌ ABSENT</p>
                @endif
                @if($todayAttendance->check_in)
                    <p class="text-xs font-bold mt-1">In: {{ $todayAttendance->check_in->format('H:i') }}</p>
                @endif
                @if($todayAttendance->check_out)
                    <p class="text-xs font-bold">Out: {{ $todayAttendance->check_out->format('H:i') }}</p>
                @endif
            @else
                <p class="text-lg font-bold">NOT CHECKED IN</p>
                <a href="{{ route('employee.attendances.create') }}" class="neo-btn-primary neo-btn-sm mt-2 inline-block pulse-glow">CHECK IN</a>
            @endif
        </div>

        <div class="neo-card-yellow fade-in-up fade-in-up-d2">
            <p class="neo-label">Today's Shift</p>
            <p class="text-2xl font-black">{{ $userShift ? $userShift->shift->nama_shift : 'No Shift' }}</p>
            @if($userShift)
                <p class="text-xs font-bold mt-1">{{ substr($userShift->shift->jam_masuk, 0, 5) }} - {{ substr($userShift->shift->jam_pulang, 0, 5) }}</p>
            @endif
        </div>

        <div class="neo-card-pink fade-in-up fade-in-up-d3">
            <p class="neo-label">Salary</p>
            <p class="text-2xl font-black">Rp {{ number_format($user->jumlah_gaji, 0, ',', '.') }}</p>
            <p class="text-xs font-bold mt-1">{{ strtoupper($user->tipe_gaji) }}</p>
        </div>

        <div class="neo-card-cyan fade-in-up fade-in-up-d4">
            <p class="neo-label">Department</p>
            <p class="text-xl font-bold">{{ $user->department->nama_department ?? '-' }}</p>
            <p class="text-xs font-bold mt-1">{{ $user->jobTitle->nama_jabatan ?? '-' }}</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="neo-card fade-in-up fade-in-up-d3">
            <h2 class="font-black text-lg mb-4 border-b-3 border-black pb-2">Today's Attendance</h2>
            @if($todayAttendance)
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Status</p>
                        @if($todayAttendance->status_hadir == 'present')
                            <span class="neo-badge neo-badge-green status-pulse">PRESENT</span>
                        @elseif($todayAttendance->status_hadir == 'late')
                            <span class="neo-badge neo-badge-yellow">LATE</span>
                        @elseif($todayAttendance->status_hadir == 'holiday')
                            <span class="neo-badge neo-badge-cyan">HOLIDAY</span>
                        @else
                            <span class="neo-badge neo-badge-red">ABSENT</span>
                        @endif
                    </div>
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Check In</p>
                        <p class="font-black">{{ $todayAttendance->check_in ? $todayAttendance->check_in->format('H:i') : 'Not yet' }}</p>
                    </div>
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Check Out</p>
                        <p class="font-black">{{ $todayAttendance->check_out ? $todayAttendance->check_out->format('H:i') : 'Not yet' }}</p>
                    </div>
                    <div class="p-3 border-3 border-black">
                        <p class="neo-label">Work Hours</p>
                        <p class="font-black">{{ $todayAttendance->jam_kerja ? $todayAttendance->jam_kerja->format('H:i') : '-' }}</p>
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
                        <p class="font-black text-neo-cyan">{{ $todayAttendance->jam_lembur ? $todayAttendance->jam_lembur->format('H:i') : '-' }}</p>
                    </div>
                    @endif
                </div>
            @else
                <div class="text-center py-8">
                    <p class="font-bold mb-4">No attendance recorded today</p>
                    <a href="{{ route('employee.attendances.create') }}" class="neo-btn-primary pulse-glow">CHECK IN NOW</a>
                </div>
            @endif
        </div>

        <div class="neo-card-yellow fade-in-up fade-in-up-d3">
            <h2 class="font-black text-lg mb-4 border-b-3 border-black pb-2">My Info</h2>
            <ul class="space-y-2 text-sm">
                <li><strong>Name:</strong> {{ $user->nama_lengkap }}</li>
                <li><strong>Email:</strong> {{ $user->email }}</li>
                <li><strong>Phone:</strong> {{ $user->no_hp ?? '-' }}</li>
                <li><strong>Job Title:</strong> {{ $user->jobTitle->nama_jabatan ?? '-' }}</li>
                <li><strong>Salary Type:</strong> {{ strtoupper($user->tipe_gaji) }}</li>
                <li><strong>Join Date:</strong> {{ $user->tanggal_masuk->format('d M Y') }}</li>
                <li><strong>Approved Leaves:</strong> {{ $leaveCount }}</li>
                <li><strong>Status:</strong> <span class="neo-badge neo-badge-green">{{ strtoupper($user->status_akun) }}</span></li>
            </ul>
        </div>
    </div>

    @if($userShift)
    <div class="neo-card-cyan mb-6 fade-in-up fade-in-up-d4">
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

    @if(isset($upcomingHolidays) && $upcomingHolidays->count() > 0)
    <div class="neo-card-yellow p-6 mb-6 fade-in-up fade-in-up-d4">
        <h2 class="font-black text-lg mb-4 border-b-3 border-black pb-2 flex items-center gap-2">🎉 Upcoming Holidays</h2>
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            @foreach($upcomingHolidays as $holiday)
            <div class="neo-card text-center p-3">
                <p class="text-2xl font-black">{{ $holiday->tanggal->format('d') }}</p>
                <p class="text-xs font-bold">{{ $holiday->tanggal->format('M Y') }}</p>
                <p class="text-sm font-bold mt-1">{{ $holiday->nama_hari_libur }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="neo-card fade-in-up fade-in-up-d5">
            <div class="flex justify-between items-center mb-4 border-b-3 border-black pb-2">
                <h2 class="font-black text-lg">📊 Weekly Hours</h2>
            </div>
            <div class="chart-wrapper"><canvas id="weeklyChart"></canvas></div>
        </div>

        <div class="neo-card fade-in-up fade-in-up-d5">
            <div class="flex justify-between items-center mb-4 border-b-3 border-black pb-2">
                <h2 class="font-black text-lg">📈 Monthly Overview</h2>
            </div>
            <div class="grid grid-cols-3 gap-3 mb-4">
                <div class="neo-card-green text-center p-3">
                    <p class="text-xs font-bold uppercase">Present</p>
                    <p class="text-2xl font-black count-up">{{ $presentDays }}</p>
                </div>
                <div class="neo-card-yellow text-center p-3">
                    <p class="text-xs font-bold uppercase">Late</p>
                    <p class="text-2xl font-black count-up">{{ $lateDays }}</p>
                </div>
                <div class="neo-card-red text-center p-3">
                    <p class="text-xs font-bold uppercase">Absent</p>
                    <p class="text-2xl font-black count-up">{{ $totalDays - $presentDays }}</p>
                </div>
            </div>
            @if($totalDays > 0)
            <div class="mb-2">
                <div class="flex justify-between text-xs font-bold mb-1">
                    <span>Attendance Rate</span>
                    <span>{{ $totalDays > 0 ? round(($presentDays / $totalDays) * 100) : 0 }}%</span>
                </div>
                <div class="h-3 border-2 border-black bg-white overflow-hidden">
                    <div class="h-full bg-[#00f5d4] transition-all duration-1000 ease-out" style="width: {{ $totalDays > 0 ? ($presentDays / $totalDays) * 100 : 0 }}%"></div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="neo-card fade-in-up fade-in-up-d6">
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
                            <td>{{ $item->check_in ? $item->check_in->format('H:i') : '-' }}</td>
                            <td>
                                @if($item->status_hadir == 'present')
                                    <span class="neo-badge neo-badge-green">PRESENT</span>
                                @elseif($item->status_hadir == 'late')
                                    <span class="neo-badge neo-badge-yellow">LATE</span>
                                @elseif($item->status_hadir == 'holiday')
                                    <span class="neo-badge neo-badge-cyan">HOLIDAY</span>
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

        <div class="neo-card-purple fade-in-up fade-in-up-d6">
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const font = { family: 'Space Mono', weight: 'bold' };
    var weeklyCtx = document.getElementById('weeklyChart');
    if (weeklyCtx) {
        var chart = new Chart(weeklyCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($weeklyData, 'date')) !!},
                datasets: [{
                    label: 'Hours',
                    data: {!! json_encode(array_column($weeklyData, 'hours_numeric')) !!},
                    backgroundColor: ['#00f5d4', '#fee440', '#f15bb5', '#00bbf9', '#9b5de5', '#ff6b35', '#e63946'],
                    borderColor: '#000',
                    borderWidth: 2,
                    borderRadius: 0,
                    hoverBackgroundColor: '#fee440',
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                animation: { duration: 800, easing: 'easeOutQuart' },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#000',
                        titleFont: font,
                        bodyFont: font,
                        borderColor: '#fee440',
                        borderWidth: 2,
                        padding: 10,
                        cornerRadius: 0,
                        callbacks: {
                            label: function(ctx) {
                                return ctx.parsed.y + ' hours';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#000', lineWidth: 1 },
                        ticks: { font }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font }
                    }
                }
            }
        });
        weeklyCtx.parentElement.addEventListener('click', function() {
            chart.reset();
            chart.update();
        });
    }

    // Count-up animation
    document.querySelectorAll('.count-up').forEach(function(el) {
        var target = parseInt(el.textContent.trim());
        if (isNaN(target) || target === 0) return;
        var duration = 1000, startTime = null;
        function step(ts) {
            if (!startTime) startTime = ts;
            var p = Math.min((ts - startTime) / duration, 1);
            el.textContent = Math.floor((1 - Math.pow(1 - p, 3)) * target);
            if (p < 1) requestAnimationFrame(step);
            else el.textContent = target;
        }
        requestAnimationFrame(step);
    });
});
</script>
@endpush
