<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user', 'location');

        if ($search = $request->search) {
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$search}%"));
        }
        if ($request->date_from) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }
        if ($request->status) {
            $query->where('status_hadir', $request->status);
        }

        $attendances = $query->latest('tanggal')->paginate(20)->withQueryString();

        $total = Attendance::count();
        $totalPresent = Attendance::where('status_hadir', 'present')->count();
        $totalLate = Attendance::where('status_hadir', 'late')->count();
        $totalAbsent = Attendance::where('status_hadir', 'absent')->count();
        $todayTotal = Attendance::whereDate('tanggal', today())->count();
        $todayOnTime = Attendance::whereDate('tanggal', today())->where('status_hadir', 'present')->count();
        $todayOnTime = $todayTotal > 0 ? round(($todayOnTime / $todayTotal) * 100) : 0;

        return view('hr.attendances.index', compact('attendances', 'total', 'totalPresent', 'totalLate', 'totalAbsent', 'todayTotal', 'todayOnTime'));
    }

    public function export(Request $request)
    {
        $query = Attendance::with('user', 'location');

        if ($search = $request->search) {
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$search}%"));
        }
        if ($request->date_from) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }
        if ($request->date_to) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }
        if ($request->status) {
            $query->where('status_hadir', $request->status);
        }

        $attendances = $query->latest('tanggal')->get();

        $filename = 'attendance-export-' . now()->format('Y-m-d') . '.csv';

        return response()->stream(function () use ($attendances) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Employee', 'Date', 'Check In', 'Check Out', 'Status', 'Location']);
            foreach ($attendances as $a) {
                fputcsv($handle, [
                    $a->user->nama_lengkap ?? 'N/A',
                    $a->tanggal ? $a->tanggal->format('d M Y') : '',
                    $a->check_in ?? '',
                    $a->check_out ?? '',
                    $a->status_hadir ?? '',
                    $a->location->nama_lokasi ?? '',
                ]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
