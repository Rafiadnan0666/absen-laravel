<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index()
    {
        $leaves = Leave::with('user')->latest()->paginate(20);
        return view('hr.leaves.index', compact('leaves'));
    }

    public function approve(Leave $leave)
    {
        $leave->update(['status_pengajuan' => 'approved']);
        return back()->with('success', 'Leave approved');
    }

    public function reject(Leave $leave)
    {
        $leave->update(['status_pengajuan' => 'rejected']);
        return back()->with('success', 'Leave rejected');
    }
}
