<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\UserShift;
use Illuminate\Http\Request;

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
        
        return view('employee.dashboard.index', compact('user', 'todayAttendance', 'recentAttendances', 'leaves', 'userShift'));
    }
}
