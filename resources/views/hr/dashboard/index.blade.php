@extends('hr.dashboard.layout')

@section('page-title', 'HR Dashboard')

@section('content')
    <h1 class="neo-section-title fade-in-up">HR DASHBOARD</h1>

    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="neo-card-green fade-in-up fade-in-up-d1">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase">Present Today</p>
                    <p class="text-4xl font-black count-up">{{ $presentToday }}</p>
                    <p class="text-xs font-bold">{{ $lateToday }} late</p>
                </div>
                <div class="neo-avatar bg-neo-green text-black float">✅</div>
            </div>
        </div>

        <div class="neo-card-yellow fade-in-up fade-in-up-d2">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase">Pending Leaves</p>
                    <p class="text-4xl font-black">{{ $pendingLeaves->count() }}</p>
                    <p class="text-xs font-bold">Requests</p>
                </div>
                <div class="neo-avatar bg-neo-orange text-black float" style="animation-delay:0.5s;">🏖️</div>
            </div>
        </div>

        <div class="neo-card-cyan fade-in-up fade-in-up-d3">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase">Pending Reimburse</p>
                    <p class="text-4xl font-black">{{ $pendingReimbursements->count() }}</p>
                    <p class="text-xs font-bold">Requests</p>
                </div>
                <div class="neo-avatar bg-neo-cyan text-black float" style="animation-delay:1s;">💰</div>
            </div>
        </div>

        <div class="neo-card-purple fade-in-up fade-in-up-d4">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-sm font-bold uppercase">Active Employees</p>
                    <p class="text-4xl font-black">{{ $totalEmployees }}</p>
                    <p class="text-xs font-bold">Total workforce</p>
                </div>
                <div class="neo-avatar bg-neo-purple text-black float" style="animation-delay:1.5s;">👥</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="neo-card fade-in-up fade-in-up-d3">
            <div class="mb-4 border-b-3 border-black pb-4">
                <h2 class="font-black text-lg">📈 Weekly Attendance</h2>
            </div>
            <div class="chart-wrapper"><canvas id="hrWeeklyChart"></canvas></div>
        </div>

        <div class="neo-card fade-in-up fade-in-up-d3">
            <div class="mb-4 border-b-3 border-black pb-4">
                <h2 class="font-black text-lg">📊 This Month</h2>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div class="neo-card-green text-center p-6">
                    <p class="neo-label">Present</p>
                    <p class="text-3xl font-black">{{ $monthlyPresent }}</p>
                </div>
                <div class="neo-card-red text-center p-6">
                    <p class="neo-label">Absent</p>
                    <p class="text-3xl font-black">{{ $monthlyAbsent }}</p>
                </div>
            </div>
            @if(($monthlyPresent + $monthlyAbsent) > 0)
            <div class="mt-4">
                <div class="flex justify-between text-xs font-bold mb-1">
                    <span>Attendance Rate</span>
                    <span>{{ round(($monthlyPresent / max($monthlyPresent + $monthlyAbsent, 1)) * 100) }}%</span>
                </div>
                <div class="h-3 border-2 border-black bg-white overflow-hidden">
                    <div class="h-full bg-[#00f5d4] transition-all duration-1000" style="width: {{ ($monthlyPresent / max($monthlyPresent + $monthlyAbsent, 1)) * 100 }}%"></div>
                </div>
            </div>
            @endif
        </div>
    </div>

    <div class="neo-card mb-6 fade-in-up fade-in-up-d4">
        <div class="flex justify-between items-center mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">Today's Attendance</h2>
            <a href="{{ route('hr.attendances.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
        </div>
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
                        <td>{{ $attendance->check_in ? $attendance->check_in->format('H:i') : '-' }}</td>
                        <td>{{ $attendance->check_out ? $attendance->check_out->format('H:i') : '-' }}</td>
                        <td>
                            @if($attendance->status_hadir == 'present')
                                <span class="neo-badge neo-badge-green status-pulse">PRESENT</span>
                            @elseif($attendance->status_hadir == 'late')
                                <span class="neo-badge neo-badge-yellow">LATE</span>
                            @elseif($attendance->status_hadir == 'holiday')
                                <span class="neo-badge neo-badge-cyan">HOLIDAY</span>
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

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="neo-card-yellow fade-in-up fade-in-up-d5">
            <div class="flex justify-between items-center mb-4 border-b-3 border-black pb-4">
                <h2 class="font-black text-lg">Pending Leaves</h2>
                <a href="{{ route('hr.leaves.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
            </div>
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
                            <td><span class="neo-badge neo-badge-cyan">{{ strtoupper($leave->tipe_cuti) }}</span></td>
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

        <div class="neo-card-cyan fade-in-up fade-in-up-d5">
            <div class="flex justify-between items-center mb-4 border-b-3 border-black pb-4">
                <h2 class="font-black text-lg">Pending Reimbursements</h2>
                <a href="{{ route('hr.reimbursements.index') }}" class="neo-btn-secondary neo-btn-sm">VIEW ALL</a>
            </div>
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
                            <td><span class="neo-badge neo-badge-purple">{{ strtoupper($reimbursement->kategori) }}</span></td>
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const font = { family: 'Space Mono', weight: 'bold' };
    var ctx = document.getElementById('hrWeeklyChart');
    if (ctx) {
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_column($weeklyTrend, 'date')) !!},
                datasets: [{
                    label: 'Present',
                    data: {!! json_encode(array_column($weeklyTrend, 'present')) !!},
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
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#000', lineWidth: 1 },
                        ticks: { font, stepSize: 1 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font }
                    }
                }
            }
        });
        ctx.parentElement.addEventListener('click', function() {
            chart.reset();
            chart.update();
        });
    }

    // Count-up
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

    // Confetti
    function createConfetti() {
        var emojis = ['👥', '📊', '✅', '✨'];
        for (var i = 0; i < 10; i++) {
            var el = document.createElement('div');
            el.className = 'confetti-piece';
            el.textContent = emojis[i % emojis.length];
            el.style.left = Math.random() * 100 + 'vw';
            el.style.fontSize = (14 + Math.random() * 12) + 'px';
            el.style.animationDuration = (2 + Math.random() * 3) + 's';
            el.style.animationDelay = Math.random() * 0.5 + 's';
            document.body.appendChild(el);
            setTimeout(function(e) { e.remove(); }, 5000, el);
        }
    }
    setTimeout(createConfetti, 600);
});
</script>
@endpush
