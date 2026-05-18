<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\Department;
use App\Models\Reimbursement;
use App\Models\Holiday;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalEmployees = User::whereHas('role', function($query) {
            $query->where('nama_role', 'employee');
        })->count();
        $totalDepartments = Department::count();
        $totalLeaves = Leave::count();

        $pendingLeaves = Leave::where('status_pengajuan', 'pending')->count();
        $pendingReimbursements = Reimbursement::where('status', 'pending')->count();

        $todayAttendance = Attendance::whereDate('tanggal', today());
        $todayPresent = (clone $todayAttendance)->where('status_hadir', 'present')->count();
        $todayLate = (clone $todayAttendance)->where('status_hadir', 'late')->count();
        $todayAbsent = (clone $todayAttendance)->where('status_hadir', 'absent')->count();

        $thisMonthPayroll = Payroll::whereYear('periode_mulai', now()->year)
            ->whereMonth('periode_mulai', now()->month);
        $totalPayrollThisMonth = (clone $thisMonthPayroll)->sum('total_gaji');
        $paidPayrollCount = (clone $thisMonthPayroll)->where('status_pembayaran', 'paid')->count();
        $pendingPayrollCount = (clone $thisMonthPayroll)->where('status_pembayaran', 'pending')->count();

        $departments = Department::withCount('users')->orderBy('users_count', 'desc')->get();
        $departmentLabels = $departments->pluck('nama_department');
        $departmentCounts = $departments->pluck('users_count');

        $months = collect();
        $attendanceMonthly = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthLabel = $date->format('M Y');
            $months->push($monthLabel);

            $monthAttendance = Attendance::whereYear('tanggal', $date->year)
                ->whereMonth('tanggal', $date->month);
            $present = (clone $monthAttendance)->where('status_hadir', 'present')->count();
            $late = (clone $monthAttendance)->where('status_hadir', 'late')->count();
            $absent = (clone $monthAttendance)->where('status_hadir', 'absent')->count();

            $attendanceMonthly->push([
                'month' => $monthLabel,
                'present' => $present,
                'late' => $late,
                'absent' => $absent,
            ]);
        }

        $leaveStatuses = [
            'approved' => Leave::where('status_pengajuan', 'approved')->count(),
            'pending' => Leave::where('status_pengajuan', 'pending')->count(),
            'rejected' => Leave::where('status_pengajuan', 'rejected')->count(),
        ];

        $payrollMonthly = collect();
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $total = Payroll::whereYear('periode_mulai', $date->year)
                ->whereMonth('periode_mulai', $date->month)
                ->sum('total_gaji');
            $payrollMonthly->push([
                'month' => $date->format('M Y'),
                'total' => (float) $total,
            ]);
        }

        $recentAttendances = Attendance::with('user')->latest('tanggal')->take(5)->get();
        $recentLeaves = Leave::with('user')->latest('tanggal_mulai')->take(5)->get();
        $recentPayrolls = Payroll::with('user')->latest('created_at')->take(5)->get();
        $recentReimbursements = Reimbursement::with('user')->latest('created_at')->take(5)->get();

        $holidaysThisMonth = Holiday::whereYear('tanggal', now()->year)
            ->whereMonth('tanggal', now()->month)->count();

        $employeeStatusCounts = User::selectRaw("
            SUM(CASE WHEN status_akun = 'active' THEN 1 ELSE 0 END) as active,
            SUM(CASE WHEN status_akun = 'inactive' THEN 1 ELSE 0 END) as inactive
        ")->whereHas('role', function($q) {
            $q->where('nama_role', 'employee');
        })->first();

        return view('admin.dashboard.index', compact(
            'totalUsers', 'totalEmployees', 'totalDepartments', 'totalLeaves',
            'pendingLeaves', 'pendingReimbursements',
            'todayPresent', 'todayLate', 'todayAbsent',
            'totalPayrollThisMonth', 'paidPayrollCount', 'pendingPayrollCount',
            'departmentLabels', 'departmentCounts',
            'months', 'attendanceMonthly',
            'leaveStatuses', 'payrollMonthly',
            'recentAttendances', 'recentLeaves', 'recentPayrolls', 'recentReimbursements',
            'holidaysThisMonth', 'employeeStatusCounts'
        ));
    }
}
