<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::with('user', 'location')->latest('tanggal')->paginate(20);
        return view('hr.attendances.index', compact('attendances'));
    }
}
