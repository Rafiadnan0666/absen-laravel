<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;
use App\Services\PayrollService;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function __construct(private readonly PayrollService $payrolls)
    {
    }

    public function index()
    {
        $payrolls = Payroll::with('user', 'confirmedBy')->latest('periode_mulai')->paginate(20);
        return view('admin.payrolls.index', compact('payrolls'));
    }

    public function create()
    {
        $users = User::where('status_akun', 'active')->get();
        return view('admin.payrolls.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'gaji_pokok' => 'required|numeric|min:0',
            'total_lembur' => 'nullable|numeric|min:0',
            'total_potongan' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
        ]);

        $this->payrolls->create($validated);

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll created and awaiting confirmation');
    }

    public function show(Payroll $payroll)
    {
        $payroll->load('details', 'confirmedBy', 'auditLogs.user');
        return view('admin.payrolls.show', compact('payroll'));
    }

    public function edit(Payroll $payroll)
    {
        $users = User::where('status_akun', 'active')->get();
        return view('admin.payrolls.edit', compact('payroll', 'users'));
    }

    public function update(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'gaji_pokok' => 'required|numeric|min:0',
            'total_lembur' => 'nullable|numeric|min:0',
            'total_potongan' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
        ]);

        $this->payrolls->update($payroll, $validated);

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll updated');
    }

    public function confirm(Payroll $payroll)
    {
        $this->payrolls->confirm($payroll);

        return back()->with('success', 'Payroll confirmed and ready for payment');
    }

    public function reject(Request $request, Payroll $payroll)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $this->payrolls->reject($payroll, $validated['rejection_reason']);

        return back()->with('success', 'Payroll confirmation rejected');
    }

    public function markPaid(Payroll $payroll)
    {
        $this->payrolls->markPaid($payroll);

        return back()->with('success', 'Payroll marked as paid');
    }

    public function destroy(Payroll $payroll)
    {
        $this->payrolls->delete($payroll);

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll deleted');
    }
}
