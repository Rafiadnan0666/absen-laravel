<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $query = Payroll::with('user');

        if ($search = $request->search) {
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$search}%"));
        }
        if ($request->status) {
            $query->where('status_pembayaran', $request->status);
        }
        if ($request->periode) {
            $query->whereYear('periode_mulai', substr($request->periode, 0, 4))
                  ->whereMonth('periode_mulai', substr($request->periode, 5, 2));
        }

        $payrolls = $query->latest('periode_mulai')->paginate(20)->withQueryString();

        $totalPayroll = Payroll::count();
        $totalPaid = Payroll::where('status_pembayaran', 'paid')->count();
        $totalPending = Payroll::where('status_pembayaran', 'pending')->count();
        $totalAmount = Payroll::where('status_pembayaran', 'paid')->sum('total_gaji');

        return view('hr.payrolls.index', compact('payrolls', 'totalPayroll', 'totalPaid', 'totalPending', 'totalAmount'));
    }
}
