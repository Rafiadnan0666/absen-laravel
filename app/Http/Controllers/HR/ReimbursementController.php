<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Concerns\HandlesApproval;
use App\Http\Controllers\Controller;
use App\Models\Reimbursement;

class ReimbursementController extends Controller
{
    use HandlesApproval;

    public function index()
    {
        $reimbursements = Reimbursement::with('user')->latest()->paginate(20);
        return view('hr.reimbursements.index', compact('reimbursements'));
    }

    public function approve(Reimbursement $reimbursement)
    {
        $this->approveRecord($reimbursement);
        return back()->with('success', 'Reimbursement approved');
    }

    public function reject(Reimbursement $reimbursement)
    {
        $this->rejectRecord($reimbursement);
        return back()->with('success', 'Reimbursement rejected');
    }
}
