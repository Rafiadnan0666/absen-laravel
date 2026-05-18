<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $query = Payroll::with('user:id,nama_lengkap,email');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status_pembayaran', $request->status);
        }

        if ($request->filled('periode_from')) {
            $query->whereDate('periode_mulai', '>=', $request->periode_from);
        }

        if ($request->filled('periode_to')) {
            $query->whereDate('periode_selesai', '<=', $request->periode_to);
        }

        $payrolls = $query->latest('periode_mulai')->paginate($request->per_page ?? 15);

        return response()->json($payrolls);
    }

    public function show(Payroll $payroll)
    {
        return response()->json($payroll->load('user', 'details'));
    }
}
