<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = Attendance::with('user', 'location');

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status_hadir', $request->status);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $users = User::where('status_akun', 'active')->orderBy('nama_lengkap')->take(100)->get();

        $attendances = $query->latest('tanggal')->paginate(20)->withQueryString();
        return view('hr.attendances.index', compact('attendances', 'users'));
    }
}
