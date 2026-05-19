<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\OvertimeRule;
use App\Models\Payroll;
use App\Models\SalaryRule;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class PayrollController extends Controller
{
    public function index(Request $request)
    {
        $query = Payroll::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"));
        }

        if ($request->filled('filterStatus')) {
            $query->where('status_pembayaran', $request->filterStatus);
        }

        if ($request->filled('filterUserId')) {
            $query->where('user_id', $request->filterUserId);
        }

        if ($request->filled('periodeFrom')) {
            $query->whereDate('periode_mulai', '>=', $request->periodeFrom);
        }

        if ($request->filled('periodeTo')) {
            $query->whereDate('periode_selesai', '<=', $request->periodeTo);
        }

        $payrolls = $query->latest('periode_mulai')->paginate(20)->withQueryString();
        $users = User::where('status_akun', 'active')->get();

        if ($request->ajax()) {
            return view('admin.payrolls._table', compact('payrolls'))->render();
        }

        $totalPayroll = Payroll::count();
        $totalPaid = Payroll::where('status_pembayaran', 'paid')->count();
        $totalPending = Payroll::where('status_pembayaran', 'pending')->count();
        $totalAmount = Payroll::sum('total_gaji');

        return view('admin.payrolls.index', compact(
            'payrolls', 'users',
            'totalPayroll', 'totalPaid', 'totalPending', 'totalAmount'
        ));
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

        $validated['total_gaji'] = $validated['gaji_pokok']
            + ($validated['total_lembur'] ?? 0)
            + ($validated['bonus'] ?? 0)
            - ($validated['total_potongan'] ?? 0);

        Payroll::create($validated);
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

        $validated['total_gaji'] = $validated['gaji_pokok']
            + ($validated['total_lembur'] ?? 0)
            + ($validated['bonus'] ?? 0)
            - ($validated['total_potongan'] ?? 0);

        $payroll->update($validated);
        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll updated');
    }

    public function destroy(Payroll $payroll)
    {
        $payroll->delete();
        return redirect()->route('admin.payrolls.index')->with('success', 'Payroll deleted');
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $user = User::findOrFail($request->user_id);
        $salaryRule = SalaryRule::getRuleForUser($user);
        $start = Carbon::parse($request->periode_mulai);
        $end = Carbon::parse($request->periode_selesai);

        $attendances = Attendance::where('user_id', $user->id)
            ->whereBetween('tanggal', [$start, $end])
            ->get();

        $totalOvertimeMinutes = 0;
        $totalLateMinutes = 0;
        $absentDays = 0;

        foreach ($attendances as $a) {
            if ($a->jam_lembur) {
                $totalOvertimeMinutes += $a->jam_lembur->hour * 60 + $a->jam_lembur->minute;
            }
            $totalLateMinutes += $a->menit_telat ?? 0;
            if (($a->status_hadir ?? '') === 'alfa') {
                $absentDays++;
            }
        }

        $overtimeHours = $totalOvertimeMinutes / 60;

        $hourlyRate = match ($user->tipe_gaji) {
            'monthly' => $user->jumlah_gaji / (22 * 8),
            'daily' => $user->jumlah_gaji / 8,
            'hourly' => $user->jumlah_gaji,
            default => 0,
        };

        $overtimePay = OvertimeRule::calculateOvertimePay($overtimeHours, $hourlyRate);

        $latePenalty = $salaryRule
            ? $totalLateMinutes * $salaryRule->penalti_telat_per_menit
            : 0;

        $absentPenalty = $salaryRule
            ? $absentDays * $salaryRule->penalti_tidak_hadir
            : 0;

        $totalDeductions = $latePenalty + $absentPenalty;

        return response()->json([
            'gaji_pokok' => (float) $user->jumlah_gaji,
            'total_lembur' => round($overtimePay, 2),
            'total_potongan' => round($totalDeductions, 2),
            'total_late_minutes' => $totalLateMinutes,
            'total_overtime_hours' => round($overtimeHours, 2),
            'absent_days' => $absentDays,
        ]);
    }

    public function export(Request $request)
    {
        $query = Payroll::with('user');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"));
        }
        if ($request->filled('filterStatus')) {
            $query->where('status_pembayaran', $request->filterStatus);
        }
        if ($request->filled('filterUserId')) {
            $query->where('user_id', $request->filterUserId);
        }
        if ($request->filled('periodeFrom')) {
            $query->whereDate('periode_mulai', '>=', $request->periodeFrom);
        }
        if ($request->filled('periodeTo')) {
            $query->whereDate('periode_selesai', '<=', $request->periodeTo);
        }

        $payrolls = $query->latest('periode_mulai')->get();

        $filename = 'payrolls-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($payrolls) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['ID', 'Employee', 'Period Start', 'Period End', 'Base Salary', 'Overtime', 'Deductions', 'Bonus', 'Total', 'Status']);

            foreach ($payrolls as $p) {
                fputcsv($handle, [
                    $p->id,
                    $p->user->nama_lengkap ?? 'N/A',
                    $p->periode_mulai->format('Y-m-d'),
                    $p->periode_selesai->format('Y-m-d'),
                    $p->gaji_pokok,
                    $p->total_lembur ?? 0,
                    $p->total_potongan ?? 0,
                    $p->bonus ?? 0,
                    $p->total_gaji,
                    $p->status_pembayaran,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
