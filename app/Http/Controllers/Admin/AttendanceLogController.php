<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AttendanceLog;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AttendanceLog::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"));
        }

        if ($request->filled('filterType')) {
            $query->where('tipe_log', $request->filterType);
        }

        if ($request->filled('filterDevice')) {
            $query->where('device', $request->filterDevice);
        }

        if ($request->filled('dateFrom')) {
            $query->whereDate('waktu_log', '>=', $request->dateFrom);
        }

        if ($request->filled('dateTo')) {
            $query->whereDate('waktu_log', '<=', $request->dateTo);
        }

        $attendanceLogs = $query->latest('waktu_log')->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return view('admin.attendance-logs._table', compact('attendanceLogs'))->render();
        }

        $totalLogs = AttendanceLog::count();
        $checkInCount = AttendanceLog::where('tipe_log', 'check_in')->count();
        $checkOutCount = AttendanceLog::where('tipe_log', 'check_out')->count();

        return view('admin.attendance-logs.index', compact(
            'attendanceLogs', 'totalLogs', 'checkInCount', 'checkOutCount'
        ));
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
