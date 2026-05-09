<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $attendanceCount = Attendance::count();
        $leaveCount = Leave::count();
        $payrollCount = Payroll::count();

        return view('admin.dashboard.index', compact('userCount', 'attendanceCount', 'leaveCount', 'payrollCount'));
    }
}
