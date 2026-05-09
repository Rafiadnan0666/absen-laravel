<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\Reimbursement;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $todayAttendances = Attendance::with('user')->whereDate('tanggal', today())->get();
        $pendingLeaves = Leave::with('user')->where('status_pengajuan', 'pending')->get();
        $pendingReimbursements = Reimbursement::with('user')->where('status_pengajuan', 'pending')->get();
        
        return view('hr.dashboard.index', compact('todayAttendances', 'pendingLeaves', 'pendingReimbursements'));
    }
}
