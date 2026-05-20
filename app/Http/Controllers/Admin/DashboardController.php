<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\Reimbursement;
use App\Models\Department;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        // Stats
        $totalUsers = User::count();
        $activeUsers = User::where('status_akun', 'active')->count();
        $presentToday = Attendance::whereDate('tanggal', today())
            ->where('status_hadir', 'present')->count();
        $lateToday = Attendance::whereDate('tanggal', today())
            ->where('status_hadir', 'late')->count();
        $pendingLeaves = Leave::where('status_pengajuan', 'pending')->count();
        $pendingReimbursements = Reimbursement::where('status', 'pending')->count();
        $totalDepartments = Department::count();
        $totalPayrollThisMonth = Payroll::whereMonth('periode_mulai', $now->month)
            ->whereYear('periode_mulai', $now->year)->count();

        // Monthly attendance trend
        $monthlyAttendance = [];
        for ($m = 1; $m <= 12; $m++) {
            $date = Carbon::create($now->year, $m, 1);
            $monthlyAttendance[] = [
                'month' => $date->format('M'),
                'present' => Attendance::whereMonth('tanggal', $m)
                    ->whereYear('tanggal', $now->year)
                    ->whereIn('status_hadir', ['present', 'late'])->count(),
                'absent' => Attendance::whereMonth('tanggal', $m)
                    ->whereYear('tanggal', $now->year)
                    ->where('status_hadir', 'absent')->count(),
            ];
        }

        // Weekly trend (last 7 days)
        $weeklyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $weeklyTrend[] = [
                'date' => $day->format('D'),
                'day' => $day->format('d'),
                'present' => Attendance::whereDate('tanggal', $day)
                    ->whereIn('status_hadir', ['present', 'late'])->count(),
                'absent' => Attendance::whereDate('tanggal', $day)
                    ->where('status_hadir', 'absent')->count(),
            ];
        }

        // Department distribution
        $departments = Department::withCount('users')->get();

        // Recent attendances
        $recentAttendances = Attendance::with('user')
            ->latest('tanggal')
            ->take(8)
            ->get();

        // Recent leaves
        $recentLeaves = Leave::with('user')
            ->latest('tanggal_mulai')
            ->take(5)
            ->get();

        $recentReimbursements = Reimbursement::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Leave type distribution
        $leaveTypes = [
            'sick' => Leave::where('tipe_cuti', 'sick')->count(),
            'annual' => Leave::where('tipe_cuti', 'annual')->count(),
            'unpaid' => Leave::where('tipe_cuti', 'unpaid')->count(),
        ];

        return view('admin.dashboard.index', compact(
            'totalUsers', 'activeUsers', 'presentToday', 'lateToday',
            'pendingLeaves', 'pendingReimbursements', 'totalDepartments',
            'totalPayrollThisMonth', 'monthlyAttendance', 'weeklyTrend',
            'departments', 'recentAttendances', 'recentLeaves',
            'recentReimbursements', 'leaveTypes'
        ));
    }
}
