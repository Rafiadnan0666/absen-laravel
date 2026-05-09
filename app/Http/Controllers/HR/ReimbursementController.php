<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Reimbursement;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    public function index()
    {
        $reimbursements = Reimbursement::with('user')->latest()->paginate(20);
        return view('hr.reimbursements.index', compact('reimbursements'));
    }

    public function approve(Reimbursement $reimbursement)
    {
        $reimbursement->update(['status_pengajuan' => 'approved']);
        return back()->with('success', 'Reimbursement approved');
    }

    public function reject(Reimbursement $reimbursement)
    {
        $reimbursement->update(['status_pengajuan' => 'rejected']);
        return back()->with('success', 'Reimbursement rejected');
    }
}
