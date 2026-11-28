<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\OvertimeRule;
use App\Models\Payroll;
use App\Models\Reimbursement;
use App\Models\SalaryRule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class PayrollCalculationService
{
    public function calculate(User $user, string $periodeMulai, string $periodeSelesai): array
    {
        $startDate = Carbon::parse($periodeMulai);
        $endDate = Carbon::parse($periodeSelesai);

        $salaryRule = SalaryRule::where('tipe_gaji', $user->tipe_gaji)->first();

        $gajiPokok = $this->calculateBaseSalary($user, $startDate, $endDate, $salaryRule);
        $totalLembur = $this->calculateOvertime($user, $startDate, $endDate);
        $totalPotongan = $this->calculateDeductions($user, $startDate, $endDate, $salaryRule);
        $bonus = $this->calculateBonus($user, $startDate, $endDate);
        $reimbursements = $this->calculateReimbursements($user, $startDate, $endDate);

        $totalGaji = $gajiPokok + $totalLembur + $bonus + $reimbursements - $totalPotongan;

        return [
            'gaji_pokok' => $gajiPokok,
            'total_lembur' => $totalLembur,
            'total_potongan' => $totalPotongan,
            'bonus' => $bonus,
            'reimbursements' => $reimbursements,
            'total_gaji' => $totalGaji,
            'breakdown' => [
                'base_salary' => $gajiPokok,
                'overtime' => $totalLembur,
                'deductions' => $totalPotongan,
                'bonus' => $bonus,
                'reimbursements' => $reimbursements,
            ],
        ];
    }

    public function calculateForMultipleUsers(Collection $users, string $periodeMulai, string $periodeSelesai): array
    {
        $results = [];
        foreach ($users as $user) {
            $results[$user->id] = $this->calculate($user, $periodeMulai, $periodeSelesai);
        }
        return $results;
    }

    private function calculateBaseSalary(User $user, Carbon $startDate, Carbon $endDate, ?SalaryRule $salaryRule): float
    {
        if ($user->tipe_gaji === 'monthly') {
            return (float) $user->jumlah_gaji;
        }

        $workingDays = $this->getWorkingDaysInPeriod($startDate, $endDate);

        if ($user->tipe_gaji === 'daily') {
            $dailyRate = $salaryRule?->gaji_per_hari ?? ($user->jumlah_gaji / max($workingDays, 1));
            $presentDays = $this->getPresentDays($user, $startDate, $endDate);
            return $dailyRate * $presentDays;
        }

        if ($user->tipe_gaji === 'hourly') {
            $hourlyRate = $salaryRule?->gaji_per_jam ?? ($user->jumlah_gaji / (max($workingDays, 1) * 8));
            $workMinutes = $this->getWorkMinutes($user, $startDate, $endDate);
            return $hourlyRate * ($workMinutes / 60);
        }

        return (float) $user->jumlah_gaji;
    }

    private function calculateOvertime(User $user, Carbon $startDate, Carbon $endDate): float
    {
        $totalMinutes = Attendance::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereNotNull('jam_lembur')
            ->get()
            ->sum(function ($attendance) {
                if (! $attendance->jam_lembur) {
                    return 0;
                }

                return $attendance->jam_lembur->hour * 60 + $attendance->jam_lembur->minute;
            });

        if ($totalMinutes <= 0) {
            return 0.0;
        }

        $salaryRule = SalaryRule::where('tipe_gaji', $user->tipe_gaji)->first();
        $hourlyRate = (float) ($salaryRule?->rate_lembur ?? 0);

        if ($hourlyRate <= 0) {
            return 0.0;
        }

        $totalHours = $totalMinutes / 60;
        $overtimeRules = OvertimeRule::orderBy('minimal_jam')->get();

        $multiplier = 1.0;

        if ($overtimeRules->isNotEmpty()) {
            $applicableRule = $overtimeRules
                ->filter(fn ($rule) => $totalHours >= (float) $rule->minimal_jam)
                ->last();

            $multiplier = (float) ($applicableRule ?? $overtimeRules->first())->multiplier;
        }

        return $totalHours * $hourlyRate * $multiplier;
    }

    private function calculateDeductions(User $user, Carbon $startDate, Carbon $endDate, ?SalaryRule $salaryRule): float
    {
        $deductions = 0;

        $lateMinutes = Attendance::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('menit_telat');

        if ($lateMinutes > 0 && $salaryRule && $salaryRule->penalti_telat_per_menit > 0) {
            $deductions += $lateMinutes * $salaryRule->penalti_telat_per_menit;
        }

        $absentDays = $this->getAbsentDays($user, $startDate, $endDate);
        if ($absentDays > 0 && $salaryRule && $salaryRule->penalti_alfa_per_hari > 0) {
            $deductions += $absentDays * $salaryRule->penalti_alfa_per_hari;
        }

        $earlyLeaveMinutes = Attendance::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->sum('menit_pulang_cepat');

        if ($earlyLeaveMinutes > 0 && $salaryRule && $salaryRule->penalti_pulang_cepat_per_menit > 0) {
            $deductions += $earlyLeaveMinutes * $salaryRule->penalti_pulang_cepat_per_menit;
        }

        return $deductions;
    }

    private function calculateBonus(User $user, Carbon $startDate, Carbon $endDate): float
    {
        return 0;
    }

    private function calculateReimbursements(User $user, Carbon $startDate, Carbon $endDate): float
    {
        return (float) Reimbursement::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->sum('jumlah');
    }

    private function getWorkingDaysInPeriod(Carbon $startDate, Carbon $endDate): int
    {
        $days = 0;
        $current = $startDate->copy();
        while ($current->lte($endDate)) {
            if (!$current->isWeekend()) {
                $days++;
            }
            $current->addDay();
        }
        return $days;
    }

    private function getPresentDays(User $user, Carbon $startDate, Carbon $endDate): int
    {
        return Attendance::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereIn('status_hadir', ['present', 'late'])
            ->count();
    }

    private function getAbsentDays(User $user, Carbon $startDate, Carbon $endDate): int
    {
        $workingDays = $this->getWorkingDaysInPeriod($startDate, $endDate);
        $presentDays = $this->getPresentDays($user, $startDate, $endDate);
        $leaveDays = Leave::where('user_id', $user->id)
            ->where('status_pengajuan', 'approved')
            ->whereBetween('tanggal_mulai', [$startDate, $endDate])
            ->get()
            ->sum(function ($leave) use ($startDate, $endDate) {
                $leaveStart = $leave->tanggal_mulai > $startDate ? $leave->tanggal_mulai : $startDate;
                $leaveEnd = $leave->tanggal_selesai < $endDate ? $leave->tanggal_selesai : $endDate;
                return $leaveStart->diffInDays($leaveEnd) + 1;
            });

        return max(0, $workingDays - $presentDays - $leaveDays);
    }

    private function getWorkMinutes(User $user, Carbon $startDate, Carbon $endDate): int
    {
        return Attendance::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->whereNotNull('jam_kerja')
            ->get()
            ->sum(function ($attendance) {
                if (!$attendance->jam_kerja) return 0;
                return $attendance->jam_kerja->hour * 60 + $attendance->jam_kerja->minute;
            });
    }
}