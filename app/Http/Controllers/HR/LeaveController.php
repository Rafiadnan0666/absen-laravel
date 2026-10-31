<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Concerns\HandlesApproval;
use App\Http\Controllers\Controller;
use App\Models\Leave;

class LeaveController extends Controller
{
    use HandlesApproval;

    public function index()
    {
        $leaves = Leave::with('user')->latest()->paginate(20);
        return view('hr.leaves.index', compact('leaves'));
    }

    public function approve(Leave $leave)
    {
        $this->approveRecord($leave, 'status_pengajuan');
        return back()->with('success', 'Leave approved');
    }

    public function reject(Leave $leave)
    {
        $this->rejectRecord($leave, 'status_pengajuan');
        return back()->with('success', 'Leave rejected');
    }
}
