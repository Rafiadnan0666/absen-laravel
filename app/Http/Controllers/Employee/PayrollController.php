<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::where('user_id', auth()->id())
            ->latest('periode_selesai')
            ->paginate(10);

        return view('employee.payrolls.index', compact('payrolls'));
    }

    public function show(Payroll $payroll)
    {
        if ($payroll->user_id !== auth()->id()) {
            abort(403);
        }

        $payroll->load('details');

        return view('employee.payrolls.show', compact('payroll'));
    }
}
