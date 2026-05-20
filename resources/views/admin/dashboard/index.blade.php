@extends('admin.dashboard.layout')

@section('title', 'Admin Dashboard - ABS')

@section('content')
<h1 class="neo-section-title fade-in-up">ADMIN DASHBOARD</h1>

<div class="neo-card mb-6 fade-in-up fade-in-up-d1">
    <div class="mb-0">
        <p class="text-sm font-bold mb-2">Welcome back,</p>
        <h1 class="text-3xl font-black mb-2">{{ auth()->user()->nama_lengkap }}</h1>
        <p class="text-sm font-bold">Here's what's happening with your ABS system today.</p>
    </div>
</div>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="neo-card fade-in-up fade-in-up-d1">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase mb-2">TOTAL USERS</p>
                <p class="text-3xl font-black count-up">{{ $totalUsers }}</p>
                <p class="text-xs font-bold">{{ $activeUsers }} active</p>
            </div>
            <div class="neo-avatar bg-neo-purple text-black float">👥</div>
        </div>
    </div>

    <div class="neo-card-green fade-in-up fade-in-up-d2">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase mb-2">PRESENT TODAY</p>
                    <p class="text-3xl font-black count-up">{{ $presentToday }}</p>
                    <p class="text-xs font-bold">{{ $lateToday }} late</p>
                </div>
                <div class="neo-avatar bg-neo-green text-black float" style="animation-delay:0.5s;">✅</div>
        </div>
    </div>

    <div class="neo-card-yellow fade-in-up fade-in-up-d3">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase mb-2">PENDING LEAVES</p>
                <p class="text-3xl font-black">{{ $pendingLeaves }}</p>
                <p class="text-xs font-bold">{{ $totalDepartments }} departments</p>
            </div>
            <div class="neo-avatar bg-neo-orange text-black float" style="animation-delay:1s;">🏖️</div>
        </div>
    </div>

    <div class="neo-card-pink fade-in-up fade-in-up-d4">
        <div class="flex justify-between items-start">
            <div>
                <p class="text-sm font-bold uppercase mb-2">PENDING REIMBURSEMENTS</p>
                <p class="text-3xl font-black">{{ $pendingReimbursements }}</p>
                <p class="text-xs font-bold">{{ $totalPayrollThisMonth }} payrolls this month</p>
            </div>
            <div class="neo-avatar bg-neo-red text-black float" style="animation-delay:1.5s;">💰</div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    <div class="neo-card fade-in-up fade-in-up-d3">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">📈 Weekly Attendance Trend</h2>
        </div>
        <div class="chart-wrapper"><canvas id="weeklyTrendChart"></canvas></div>
    </div>

    <div class="neo-card fade-in-up fade-in-up-d3">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">📊 Monthly Attendance (Year)</h2>
        </div>
        <div class="chart-wrapper"><canvas id="monthlyChart"></canvas></div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="neo-card-green fade-in-up fade-in-up-d4">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">🏢 Department Distribution</h2>
        </div>
        <div class="chart-wrapper"><canvas id="deptChart"></canvas></div>
    </div>

    <div class="neo-card-yellow fade-in-up fade-in-up-d4">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">🏖️ Leave Types</h2>
        </div>
        <div class="chart-wrapper"><canvas id="leaveChart"></canvas></div>
    </div>

    <div class="neo-card-purple fade-in-up fade-in-up-d4">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">⚡ Quick Stats</h2>
        </div>
        <div class="space-y-4">
            @foreach($departments->take(5) as $dept)
            <div>
                <div class="flex justify-between text-xs font-bold mb-1">
                    <span>{{ $dept->nama_department }}</span>
                    <span>{{ $dept->users_count }} users</span>
                </div>
                <div class="h-2 border-2 border-black bg-white overflow-hidden">
                    <div class="h-full bg-[#00bbf9] transition-all duration-1000" style="width: {{ $totalUsers > 0 ? ($dept->users_count / $totalUsers) * 100 : 0 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="neo-card fade-in-up fade-in-up-d5">
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
                    @forelse($recentAttendances as $attendance)
                    <tr>
                        <td class="font-bold">{{ $attendance->user->nama_lengkap ?? 'N/A' }}</td>
                        <td class="text-sm">{{ $attendance->tanggal->format('d M Y') }}</td>
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
                    <tr><td colspan="3" class="text-center py-4 font-bold">No records</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="neo-card-yellow fade-in-up fade-in-up-d5">
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
                    @forelse($recentLeaves as $leave)
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

    <div class="neo-card-pink fade-in-up fade-in-up-d5">
        <div class="mb-4 border-b-3 border-black pb-4">
            <h2 class="font-black text-lg">💰 Recent Reimbursements</h2>
        </div>
        <div class="neo-table-container">
            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentReimbursements as $r)
                    <tr>
                        <td class="font-bold">{{ $r->user->nama_lengkap ?? 'N/A' }}</td>
                        <td class="font-bold">Rp {{ number_format($r->jumlah, 0, ',', '.') }}</td>
                        <td>
                            @if($r->status == 'approved')
                                <span class="neo-badge neo-badge-green">APPROVED</span>
                            @elseif($r->status == 'pending')
                                <span class="neo-badge neo-badge-yellow">PENDING</span>
                            @else
                                <span class="neo-badge neo-badge-red">REJECTED</span>
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
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const colors = {
        green: '#00f5d4', yellow: '#fee440', pink: '#f15bb5',
        cyan: '#00bbf9', purple: '#9b5de5', orange: '#ff6b35', red: '#e63946'
    };
    const font = { family: 'Space Mono', weight: 'bold' };

    function neoDefaults(extra) {
        return {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 800,
                easing: 'easeOutQuart',
            },
            plugins: {
                legend: { labels: { font } },
                tooltip: {
                    backgroundColor: '#000',
                    titleFont: { family: 'Space Mono', weight: 'bold', size: 12 },
                    bodyFont: { family: 'Space Mono', size: 11 },
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
            },
            ...extra,
        };
    }

    function createNeoChart(id, config) {
        var el = document.getElementById(id);
        if (!el) return;
        var chart = new Chart(el, {
            ...config,
            options: neoDefaults(config.options || {}),
        });
        el.parentElement.addEventListener('click', function() {
            chart.reset();
            chart.update();
        });
        return chart;
    }

    // Weekly Trend
    createNeoChart('weeklyTrendChart', {
        type: 'line',
        data: {
            labels: {!! json_encode(array_map(function($d) { return $d['date'] . ' ' . $d['day']; }, $weeklyTrend)) !!},
            datasets: [
                {
                    label: 'Present',
                    data: {!! json_encode(array_column($weeklyTrend, 'present')) !!},
                    borderColor: colors.green,
                    backgroundColor: colors.green + '33',
                    borderWidth: 3, fill: true, tension: 0.3,
                    pointBackgroundColor: '#000', pointBorderColor: '#000', pointRadius: 5,
                    pointHoverRadius: 8, pointHoverBackgroundColor: colors.yellow,
                },
                {
                    label: 'Absent',
                    data: {!! json_encode(array_column($weeklyTrend, 'absent')) !!},
                    borderColor: colors.red,
                    backgroundColor: colors.red + '33',
                    borderWidth: 3, fill: true, tension: 0.3,
                    pointBackgroundColor: '#000', pointBorderColor: '#000', pointRadius: 5,
                    pointHoverRadius: 8, pointHoverBackgroundColor: colors.yellow,
                }
            ]
        },
        options: {
            plugins: { legend: { position: 'top' } }
        }
    });

    // Monthly Chart
    createNeoChart('monthlyChart', {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_column($monthlyAttendance, 'month')) !!},
            datasets: [
                {
                    label: 'Present',
                    data: {!! json_encode(array_column($monthlyAttendance, 'present')) !!},
                    backgroundColor: colors.green,
                    borderColor: '#000', borderWidth: 2,
                    hoverBackgroundColor: '#00d4b3',
                },
                {
                    label: 'Absent',
                    data: {!! json_encode(array_column($monthlyAttendance, 'absent')) !!},
                    backgroundColor: colors.red,
                    borderColor: '#000', borderWidth: 2,
                    hoverBackgroundColor: '#d32f2f',
                }
            ]
        },
        options: {
            plugins: { legend: { position: 'top' } },
            scales: {
                y: { stacked: false },
                x: { stacked: false }
            }
        }
    });

    // Department Chart (Doughnut)
    createNeoChart('deptChart', {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($departments->pluck('nama_department')) !!},
            datasets: [{
                data: {!! json_encode($departments->pluck('users_count')) !!},
                backgroundColor: [colors.green, colors.yellow, colors.pink, colors.cyan, colors.purple, colors.orange, colors.red],
                borderColor: '#000', borderWidth: 2,
                hoverOffset: 15,
            }]
        },
        options: {
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: { font, boxWidth: 12, padding: 8 }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            var total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            var pct = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                            return ctx.label + ': ' + ctx.parsed + ' users (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });

    // Leave Chart (Doughnut)
    createNeoChart('leaveChart', {
        type: 'doughnut',
        data: {
            labels: ['Sick', 'Annual', 'Unpaid'],
            datasets: [{
                data: [{{ $leaveTypes['sick'] }}, {{ $leaveTypes['annual'] }}, {{ $leaveTypes['unpaid'] }}],
                backgroundColor: [colors.cyan, colors.yellow, colors.orange],
                borderColor: '#000', borderWidth: 2,
                hoverOffset: 15,
            }]
        },
        options: {
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'right',
                    labels: { font, boxWidth: 12, padding: 8 }
                },
                tooltip: {
                    callbacks: {
                        label: function(ctx) {
                            var total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                            var pct = total > 0 ? Math.round(ctx.parsed / total * 100) : 0;
                            return ctx.label + ': ' + ctx.parsed + ' (' + pct + '%)';
                        }
                    }
                }
            }
        }
    });

    // Count-up animation for stat numbers
    document.querySelectorAll('.count-up').forEach(function(el) {
        var target = parseInt(el.textContent.trim());
        if (isNaN(target) || target === 0) return;
        var duration = 1000, start = 0, startTime = null;
        function step(timestamp) {
            if (!startTime) startTime = timestamp;
            var progress = Math.min((timestamp - startTime) / duration, 1);
            var eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.floor(eased * target);
            if (progress < 1) requestAnimationFrame(step);
            else el.textContent = target;
        }
        requestAnimationFrame(step);
    });

    // Confetti on page load
    function createConfetti() {
        var emojis = ['🎉', '✨', '⭐', '🌟', '💫'];
        for (var i = 0; i < 15; i++) {
            var el = document.createElement('div');
            el.className = 'confetti-piece';
            el.textContent = emojis[i % emojis.length];
            el.style.left = Math.random() * 100 + 'vw';
            el.style.fontSize = (12 + Math.random() * 14) + 'px';
            el.style.animationDuration = (2 + Math.random() * 3) + 's';
            el.style.animationDelay = Math.random() * 0.5 + 's';
            document.body.appendChild(el);
            setTimeout(function(e) { e.remove(); }, 5000, el);
        }
    }
    setTimeout(createConfetti, 500);
});
</script>
@endpush
