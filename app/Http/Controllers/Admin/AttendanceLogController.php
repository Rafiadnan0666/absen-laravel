<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceLogController extends Controller
{
    public function index()
    {
        $attendanceLogs = AttendanceLog::with('user')->latest('waktu_log')->paginate(20);
        return view('admin.attendance-logs.index', compact('attendanceLogs'));
    }

    public function show(AttendanceLog $attendanceLog)
    {
        return view('admin.attendance-logs.show', compact('attendanceLog'));
    }

    public function destroy(AttendanceLog $attendanceLog)
    {
        $attendanceLog->delete();
        return redirect()->route('admin.attendance-logs.index')->with('success', 'Attendance Log deleted');
    }
}
