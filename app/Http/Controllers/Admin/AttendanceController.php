<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Location;
use App\Models\Department;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user', 'user.department', 'location');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"));
        }

        if ($request->filled('filterStatus')) {
            $query->where('status_hadir', $request->filterStatus);
        }

        if ($request->filled('filterDept')) {
            $query->whereHas('user', fn($q) => $q->where('department_id', $request->filterDept));
        }

        if ($request->filled('dateFrom')) {
            $query->whereDate('tanggal', '>=', $request->dateFrom);
        }

        if ($request->filled('dateTo')) {
            $query->whereDate('tanggal', '<=', $request->dateTo);
        }

        $attendances = $query->latest('tanggal')->paginate(20)->withQueryString();
        $departments = Department::all();

        if ($request->ajax()) {
            return view('admin.attendances._table', compact('attendances'))->render();
        }

        $total = Attendance::count();
        $totalPresent = Attendance::where('status_hadir', 'present')->count();
        $totalLate = Attendance::where('status_hadir', 'late')->count();
        $totalAbsent = Attendance::where('status_hadir', 'absent')->count();
        $todayPresent = Attendance::whereDate('tanggal', today())->where('status_hadir', 'present')->count();
        $todayLate = Attendance::whereDate('tanggal', today())->where('status_hadir', 'late')->count();
        $todayAbsent = Attendance::whereDate('tanggal', today())->where('status_hadir', 'absent')->count();

        return view('admin.attendances.index', compact(
            'attendances', 'departments',
            'total', 'totalPresent', 'totalLate', 'totalAbsent',
            'todayPresent', 'todayLate', 'todayAbsent'
        ));
    }

    public function create()
    {
        $users = User::where('status_akun', 'active')->get();
        $locations = Location::all();
        return view('admin.attendances.create', compact('users', 'locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status_hadir' => 'required|in:present,late,absent',
            'jam_kerja' => 'nullable|date_format:H:i',
            'jam_lembur' => 'nullable|date_format:H:i',
            'menit_telat' => 'nullable|integer|min:0',
            'menit_pulang_cepat' => 'nullable|integer|min:0',
            'location_id' => 'nullable|exists:locations,id',
            'face_verified' => 'nullable|boolean',
        ]);

        $validated['face_verified'] = $request->has('face_verified');
        Attendance::create($validated);
        return redirect()->route('admin.attendances.index')->with('success', 'Attendance created');
    }

    public function show(Attendance $attendance)
    {
        return view('admin.attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $users = User::where('status_akun', 'active')->get();
        $locations = Location::all();
        return view('admin.attendances.edit', compact('attendance', 'users', 'locations'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status_hadir' => 'required|in:present,late,absent',
            'jam_kerja' => 'nullable|date_format:H:i',
            'jam_lembur' => 'nullable|date_format:H:i',
            'menit_telat' => 'nullable|integer|min:0',
            'menit_pulang_cepat' => 'nullable|integer|min:0',
            'location_id' => 'nullable|exists:locations,id',
            'face_verified' => 'nullable|boolean',
        ]);

        $validated['face_verified'] = $request->has('face_verified');
        $attendance->update($validated);
        return redirect()->route('admin.attendances.index')->with('success', 'Attendance updated');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('admin.attendances.index')->with('success', 'Attendance deleted');
    }

    public function calendar()
    {
        return view('admin.attendances.calendar');
    }

    public function export(Request $request)
    {
        $query = Attendance::with('user', 'user.department', 'location');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"));
        }
        if ($request->filled('filterStatus')) {
            $query->where('status_hadir', $request->filterStatus);
        }
        if ($request->filled('filterDept')) {
            $query->whereHas('user', fn($q) => $q->where('department_id', $request->filterDept));
        }
        if ($request->filled('dateFrom')) {
            $query->whereDate('tanggal', '>=', $request->dateFrom);
        }
        if ($request->filled('dateTo')) {
            $query->whereDate('tanggal', '<=', $request->dateTo);
        }

        $attendances = $query->latest('tanggal')->get();

        $filename = 'attendances-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($attendances) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['ID', 'Employee', 'Department', 'Date', 'Check In', 'Check Out', 'Status', 'Work Hours', 'Late (min)', 'Early Leave (min)', 'Face Verified']);

            foreach ($attendances as $a) {
                fputcsv($handle, [
                    $a->id,
                    $a->user->nama_lengkap ?? 'N/A',
                    $a->user->department->nama_department ?? 'N/A',
                    $a->tanggal->format('Y-m-d'),
                    $a->check_in ?? '-',
                    $a->check_out ?? '-',
                    $a->status_hadir,
                    $a->jam_kerja ? $a->jam_kerja->format('H:i') : '-',
                    $a->menit_telat ?? 0,
                    $a->menit_pulang_cepat ?? 0,
                    $a->face_verified ? 'Yes' : 'No',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
