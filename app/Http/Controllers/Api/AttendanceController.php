<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user:id,nama_lengkap,email', 'location');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }

        if ($request->filled('status')) {
            $query->where('status_hadir', $request->status);
        }

        $attendances = $query->latest('tanggal')->paginate($request->per_page ?? 15);

        return response()->json($attendances);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status_hadir' => 'required|in:present,late,absent',
            'location_id' => 'nullable|exists:locations,id',
        ]);

        $attendance = Attendance::create($validated);

        return response()->json($attendance->load('user', 'location'), 201);
    }

    public function show(Attendance $attendance)
    {
        return response()->json($attendance->load('user', 'location'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $validated = $request->validate([
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status_hadir' => 'sometimes|in:present,late,absent',
            'location_id' => 'nullable|exists:locations,id',
        ]);

        $attendance->update($validated);

        return response()->json($attendance->load('user', 'location'));
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();

        return response()->json(['message' => 'Attendance deleted']);
    }
}
