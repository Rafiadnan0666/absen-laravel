<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function index()
    {
        $shifts = Shift::withCount('userShifts')->paginate(10);
        return view('admin.shifts.index', compact('shifts'));
    }

    public function create()
    {
        return view('admin.shifts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_shift' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'toleransi_telat_menit' => 'required|integer|min:0',
        ]);

        Shift::create($validated);
        return redirect()->route('admin.shifts.index')->with('success', 'Shift created');
    }

    public function show(Request $request, Shift $shift)
    {
        $userShifts = $shift->userShifts()->with('user')->paginate(10);
        return view('admin.shifts.show', compact('shift', 'userShifts'));
    }

    public function edit(Shift $shift)
    {
        return view('admin.shifts.edit', compact('shift'));
    }

    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'nama_shift' => 'required|string|max:255',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_pulang' => 'required|date_format:H:i',
            'toleransi_telat_menit' => 'required|integer|min:0',
        ]);

        $shift->update($validated);
        return redirect()->route('admin.shifts.index')->with('success', 'Shift updated');
    }

    public function destroy(Shift $shift)
    {
        $shift->delete();
        return redirect()->route('admin.shifts.index')->with('success', 'Shift deleted');
    }
}
