<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\Reimbursement;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();

        $todayAttendances = Attendance::with('user')->whereDate('tanggal', today())->get();
        $presentToday = Attendance::whereDate('tanggal', today())
            ->whereIn('status_hadir', ['present', 'late'])->count();
        $lateToday = Attendance::whereDate('tanggal', today())
            ->where('status_hadir', 'late')->count();

        $pendingLeaves = Leave::with('user')->where('status_pengajuan', 'pending')->get();
        $pendingReimbursements = Reimbursement::with('user')->where('status', 'pending')->get();
        $totalEmployees = User::where('status_akun', 'active')->count();

        // Weekly attendance trend
        $weeklyTrend = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $weeklyTrend[] = [
                'date' => $day->format('D'),
                'present' => Attendance::whereDate('tanggal', $day)
                    ->whereIn('status_hadir', ['present', 'late'])->count(),
            ];
        }

        // Monthly stats
        $monthlyPresent = Attendance::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->whereIn('status_hadir', ['present', 'late'])->count();

        $monthlyAbsent = Attendance::whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->where('status_hadir', 'absent')->count();

        return view('hr.dashboard.index', compact(
            'todayAttendances', 'presentToday', 'lateToday',
            'pendingLeaves', 'pendingReimbursements', 'totalEmployees',
            'weeklyTrend', 'monthlyPresent', 'monthlyAbsent'
        ));
    }
}
