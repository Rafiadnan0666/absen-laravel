<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;
use Illuminate\Http\Request;

class PayrollController extends Controller
{
    public function index()
    {
        $payrolls = Payroll::with('user')->latest('periode_mulai')->paginate(20);
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
            'status_pembayaran' => 'required|in:pending,paid',
        ]);

        $validated['total_lembur'] = $validated['total_lembur'] ?? 0;
        $validated['total_potongan'] = $validated['total_potongan'] ?? 0;
        $validated['bonus'] = $validated['bonus'] ?? 0;
        $validated['total_gaji'] = $validated['gaji_pokok'] + $validated['total_lembur'] + $validated['bonus'] - $validated['total_potongan'];

        $payroll = Payroll::create($validated);

        // Create payroll details
        if ($validated['gaji_pokok'] > 0) {
            $payroll->details()->create(['tipe' => 'base', 'jumlah' => $validated['gaji_pokok'], 'deskripsi' => 'Basic salary']);
        }
        if ($validated['total_lembur'] > 0) {
            $payroll->details()->create(['tipe' => 'overtime', 'jumlah' => $validated['total_lembur'], 'deskripsi' => 'Overtime pay']);
        }
        if ($validated['total_potongan'] > 0) {
            $payroll->details()->create(['tipe' => 'penalty', 'jumlah' => -$validated['total_potongan'], 'deskripsi' => 'Deductions']);
        }
        if ($validated['bonus'] > 0) {
            $payroll->details()->create(['tipe' => 'bonus', 'jumlah' => $validated['bonus'], 'deskripsi' => 'Bonus']);
        }

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll created');
    }

    public function show(Payroll $payroll)
    {
        $payroll->load('details');
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
            'status_pembayaran' => 'required|in:pending,paid',
        ]);

        $validated['total_lembur'] = $validated['total_lembur'] ?? 0;
        $validated['total_potongan'] = $validated['total_potongan'] ?? 0;
        $validated['bonus'] = $validated['bonus'] ?? 0;
        $validated['total_gaji'] = $validated['gaji_pokok'] + $validated['total_lembur'] + $validated['bonus'] - $validated['total_potongan'];

        $payroll->update($validated);

        // Sync details
        $payroll->details()->delete();
        if ($validated['gaji_pokok'] > 0) {
            $payroll->details()->create(['tipe' => 'base', 'jumlah' => $validated['gaji_pokok'], 'deskripsi' => 'Basic salary']);
        }
        if ($validated['total_lembur'] > 0) {
            $payroll->details()->create(['tipe' => 'overtime', 'jumlah' => $validated['total_lembur'], 'deskripsi' => 'Overtime pay']);
        }
        if ($validated['total_potongan'] > 0) {
            $payroll->details()->create(['tipe' => 'penalty', 'jumlah' => -$validated['total_potongan'], 'deskripsi' => 'Deductions']);
        }
        if ($validated['bonus'] > 0) {
            $payroll->details()->create(['tipe' => 'bonus', 'jumlah' => $validated['bonus'], 'deskripsi' => 'Bonus']);
        }

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll updated');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll deleted');
    }
}
