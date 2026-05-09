<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('user')->latest('periode_mulai')->paginate(20);
        return view('hr.payrolls.index', compact('payrolls'));
    }
}
