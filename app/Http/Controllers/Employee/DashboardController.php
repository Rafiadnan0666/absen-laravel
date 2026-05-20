<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Holiday;
use App\Models\UserShift;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $todayAttendance = Attendance::where('user_id', $user->id)
            ->whereDate('tanggal', today())
            ->first();

        $recentAttendances = Attendance::where('user_id', $user->id)
            ->latest('tanggal')
            ->take(5)
            ->get();

        $leaves = Leave::where('user_id', $user->id)
            ->latest()
            ->take(3)
            ->get();

        $userShift = UserShift::where('user_id', $user->id)
            ->whereDate('tanggal_shift', today())
            ->with('shift')
            ->first();

        $upcomingHolidays = Holiday::where('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->take(5)
            ->get();

        // Monthly attendance chart data
        $now = Carbon::now();
        $monthDays = [];
        for ($d = 1; $d <= $now->daysInMonth; $d++) {
            $date = Carbon::create($now->year, $now->month, $d);
            $dayAttendance = Attendance::where('user_id', $user->id)
                ->whereDate('tanggal', $date)
                ->first();
            $jamKerja = $dayAttendance?->jam_kerja;
            $monthDays[] = [
                'day' => $d,
                'label' => $date->format('D'),
                'status' => $dayAttendance ? $dayAttendance->status_hadir : 'none',
                'hours' => $jamKerja ? $jamKerja->format('H:i') : 0,
                'hours_numeric' => $jamKerja ? round($jamKerja->hour + $jamKerja->minute / 60, 1) : 0,
            ];
        }

        // Weekly summary for chart
        $weeklyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $day = $now->copy()->subDays($i);
            $dayAttendance = Attendance::where('user_id', $user->id)
                ->whereDate('tanggal', $day)
                ->first();
            $jamKerja = $dayAttendance?->jam_kerja;
            $weeklyData[] = [
                'date' => $day->format('D'),
                'status' => $dayAttendance ? $dayAttendance->status_hadir : 'none',
                'hours' => $jamKerja ? $jamKerja->format('H:i') : '-',
                'hours_numeric' => $jamKerja ? round($jamKerja->hour + $jamKerja->minute / 60, 1) : 0,
            ];
        }

        // Stats
        $totalDays = Attendance::where('user_id', $user->id)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->count();

        $presentDays = Attendance::where('user_id', $user->id)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->whereIn('status_hadir', ['present', 'late'])
            ->count();

        $lateDays = Attendance::where('user_id', $user->id)
            ->whereMonth('tanggal', $now->month)
            ->whereYear('tanggal', $now->year)
            ->where('status_hadir', 'late')
            ->count();

        $leaveCount = Leave::where('user_id', $user->id)
            ->where('status_pengajuan', 'approved')
            ->count();

        $recentCheckins = Attendance::where('user_id', $user->id)
            ->whereNotNull('check_in')
            ->latest('tanggal')
            ->take(7)
            ->get()
            ->map(function ($a) {
                return [
                    'date' => $a->tanggal->format('D'),
                    'checkin' => $a->check_in ? $a->check_in->format('H:i') : '-',
                    'checkout' => $a->check_out ? $a->check_out->format('H:i') : '-',
                ];
            });

        return view('employee.dashboard.index', compact(
            'user', 'todayAttendance', 'recentAttendances', 'leaves', 'userShift',
            'upcomingHolidays', 'monthDays', 'weeklyData',
            'totalDays', 'presentDays', 'lateDays', 'leaveCount', 'recentCheckins'
        ));
    }
}
