<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserShift;
use App\Models\User;
use App\Models\Shift;
use Illuminate\Http\Request;

class UserShiftController extends Controller
{
    public function index()
    {
        $userShifts = UserShift::with('user', 'shift')->latest('tanggal_shift')->paginate(20);
        return view('admin.user-shifts.index', compact('userShifts'));
    }

    public function create()
    {
        $users = User::where('status_akun', 'active')->get();
        $shifts = Shift::all();
        return view('admin.user-shifts.create', compact('users', 'shifts'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_shift' => 'required|date|unique:user_shifts,user_id,tanggal_shift',
        ]);

        UserShift::create($validated);
        return redirect()->route('admin.user-shifts.index')->with('success', 'User Shift created');
    }

    public function show(UserShift $userShift)
    {
        return view('admin.user-shifts.show', compact('userShift'));
    }

    public function edit(UserShift $userShift)
    {
        $users = User::where('status_akun', 'active')->get();
        $shifts = Shift::all();
        return view('admin.user-shifts.edit', compact('userShift', 'users', 'shifts'));
    }

    public function update(Request $request, UserShift $userShift)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'shift_id' => 'required|exists:shifts,id',
            'tanggal_shift' => 'required|date|unique:user_shifts,tanggal_shift,' . $userShift->id . ',id,user_id,' . $request->user_id,
        ]);

        $userShift->update($validated);
        return redirect()->route('admin.user-shifts.index')->with('success', 'User Shift updated');
    }

    public function destroy(UserShift $userShift)
    {
        $userShift->delete();
        return redirect()->route('admin.user-shifts.index')->with('success', 'User Shift deleted');
    }
}
