<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $query = Payroll::with('user');

        if ($request->filled('date_from')) {
            $query->whereDate('periode_mulai', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('periode_selesai', '<=', $request->date_to);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        $users = User::where('status_akun', 'active')->orderBy('nama_lengkap')->get();

        $payrolls = $query->latest('periode_mulai')->paginate(20)->withQueryString();
        return view('hr.payrolls.index', compact('payrolls', 'users'));
    }
}
