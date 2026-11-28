<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Payroll;
use App\Models\User;
use App\Services\PayrollCalculationService;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PayrollCalculationController extends Controller
{
    public function __construct(
        private readonly PayrollCalculationService $calculationService
    ) {}

    public function myPayrolls(Request $request)
    {
        $user = $request->user();

        $query = Payroll::where('user_id', $user->id);

        if ($request->filled('date_from')) {
            $query->whereDate('periode_mulai', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('periode_selesai', '<=', $request->date_to);
        }
        if ($request->filled('status_pembayaran')) {
            $query->where('status_pembayaran', $request->status_pembayaran);
        }

        $payrolls = $query->latest('periode_mulai')->paginate(15)->withQueryString();

        return response()->json($payrolls);
    }

    public function calculateMyPayroll(Request $request)
    {
        $request->validate([
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $user = $request->user();
        $calculation = $this->calculationService->calculate(
            $user,
            $request->periode_mulai,
            $request->periode_selesai
        );

        return response()->json([
            'user' => $user->only(['id', 'nama_lengkap', 'email', 'tipe_gaji', 'jumlah_gaji']),
            'period' => [
                'periode_mulai' => $request->periode_mulai,
                'periode_selesai' => $request->periode_selesai,
            ],
            'calculation' => $calculation,
        ]);
    }

    public function calculate(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $user = User::findOrFail($request->user_id);
        $calculation = $this->calculationService->calculate(
            $user,
            $request->periode_mulai,
            $request->periode_selesai
        );

        return response()->json([
            'user' => $user->only(['id', 'nama_lengkap', 'email', 'tipe_gaji', 'jumlah_gaji']),
            'period' => [
                'periode_mulai' => $request->periode_mulai,
                'periode_selesai' => $request->periode_selesai,
            ],
            'calculation' => $calculation,
        ]);
    }

    public function bulkCalculate(Request $request)
    {
        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
        ]);

        $users = User::whereIn('id', $request->user_ids)->get();
        $calculations = $this->calculationService->calculateForMultipleUsers(
            $users,
            $request->periode_mulai,
            $request->periode_selesai
        );

        $results = [];
        foreach ($calculations as $userId => $calculation) {
            $user = $users->firstWhere('id', $userId);
            $results[] = [
                'user' => $user?->only(['id', 'nama_lengkap', 'email', 'tipe_gaji', 'jumlah_gaji']),
                'period' => [
                    'periode_mulai' => $request->periode_mulai,
                    'periode_selesai' => $request->periode_selesai,
                ],
                'calculation' => $calculation,
            ];
        }

        return response()->json($results);
    }

    public function generateFromCalculation(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'periode_mulai' => 'required|date',
            'periode_selesai' => 'required|date|after_or_equal:periode_mulai',
            'gaji_pokok' => 'required|numeric|min:0',
            'total_lembur' => 'required|numeric|min:0',
            'total_potongan' => 'required|numeric|min:0',
            'bonus' => 'required|numeric|min:0',
            'total_gaji' => 'required|numeric|min:0',
        ]);

        $existingPayroll = Payroll::where('user_id', $request->user_id)
            ->where('periode_mulai', $request->periode_mulai)
            ->where('periode_selesai', $request->periode_selesai)
            ->first();

        if ($existingPayroll) {
            return response()->json([
                'message' => 'Payroll already exists for this period and user',
                'payroll' => $existingPayroll
            ], 409);
        }

        try {
            $payroll = Payroll::create([
                'user_id' => $request->user_id,
                'periode_mulai' => $request->periode_mulai,
                'periode_selesai' => $request->periode_selesai,
                'gaji_pokok' => $request->gaji_pokok,
                'total_lembur' => $request->total_lembur,
                'total_potongan' => $request->total_potongan,
                'bonus' => $request->bonus,
                'total_gaji' => $request->total_gaji,
                'status_pembayaran' => 'pending',
            ]);
        } catch (UniqueConstraintViolationException $e) {
            return response()->json([
                'message' => 'Payroll already exists for this period and user',
            ], 409);
        }

        return response()->json([
            'message' => 'Payroll created from calculation',
            'payroll' => $payroll->load('user'),
        ], 201);
    }
}