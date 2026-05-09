<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PayrollDetail;
use App\Models\Payroll;
use Illuminate\Http\Request;

class PayrollDetailController extends Controller
{
    public function index()
    {
        $payrollDetails = PayrollDetail::with('payroll.user')->latest()->paginate(20);
        return view('admin.payroll-details.index', compact('payrollDetails'));
    }

    public function create()
    {
        $payrolls = Payroll::with('user')->get();
        return view('admin.payroll-details.create', compact('payrolls'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payroll_id' => 'required|exists:payrolls,id',
            'tipe' => 'required|in:base,overtime,penalty,bonus',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        PayrollDetail::create($validated);
        return redirect()->route('admin.payroll-details.index')->with('success', 'Payroll Detail created');
    }

    public function show(PayrollDetail $payrollDetail)
    {
        return view('admin.payroll-details.show', compact('payrollDetail'));
    }

    public function edit(PayrollDetail $payrollDetail)
    {
        $payrolls = Payroll::with('user')->get();
        return view('admin.payroll-details.edit', compact('payrollDetail', 'payrolls'));
    }

    public function update(Request $request, PayrollDetail $payrollDetail)
    {
        $validated = $request->validate([
            'payroll_id' => 'required|exists:payrolls,id',
            'tipe' => 'required|in:base,overtime,penalty,bonus',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $payrollDetail->update($validated);
        return redirect()->route('admin.payroll-details.index')->with('success', 'Payroll Detail updated');
    }

    public function destroy(PayrollDetail $payrollDetail)
    {
        $payrollDetail->delete();
        return redirect()->route('admin.payroll-details.index')->with('success', 'Payroll Detail deleted');
    }
}
