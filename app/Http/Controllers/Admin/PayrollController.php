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
            'gaji_pokok' => 'nullable|numeric|min:0',
            'total_lembur' => 'nullable|numeric|min:0',
            'total_potongan' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
        ]);

        if (! array_key_exists('gaji_pokok', $validated) || $validated['gaji_pokok'] === null) {
            $validated['gaji_pokok'] = User::find($validated['user_id'])?->jumlah_gaji ?? 0;
        }

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
            'gaji_pokok' => 'nullable|numeric|min:0',
            'total_lembur' => 'nullable|numeric|min:0',
            'total_potongan' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
        ]);

        if (! array_key_exists('gaji_pokok', $validated) || $validated['gaji_pokok'] === null) {
            $validated['gaji_pokok'] = User::find($validated['user_id'])?->jumlah_gaji ?? 0;
        }

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

    public function bulkCreate()
    {
        $users = User::where('status_akun', 'active')->get();
        return view('admin.payrolls.bulk-create', compact('users'));
    }

    public function bulkStore(Request $request)
    {
        $validated = $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'total_lembur' => 'nullable|numeric|min:0',
            'total_potongan' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
        ]);

        foreach ($validated['user_ids'] as $userId) {
            $user = User::find($userId);
            $data = [
                'user_id' => $userId,
                'periode_mulai' => $validated['periode_mulai'],
                'periode_selesai' => $validated['periode_selesai'],
                'gaji_pokok' => $user?->jumlah_gaji ?? 0,
                'total_lembur' => $validated['total_lembur'] ?? 0,
                'total_potongan' => $validated['total_potongan'] ?? 0,
                'bonus' => $validated['bonus'] ?? 0,
            ];
            $this->payrolls->create($data);
        }

        return redirect()->route('admin.payrolls.index')->with('success', 'Payrolls created for selected employees');
    }

    public function destroy(Payroll $payroll)
    {
        $this->payrolls->delete($payroll);

        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll deleted');
    }
}
