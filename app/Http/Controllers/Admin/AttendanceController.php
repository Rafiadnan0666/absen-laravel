<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user', 'location')->latest('tanggal')->paginate(20);
        return view('admin.attendances.index', compact('attendances'));
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
}
