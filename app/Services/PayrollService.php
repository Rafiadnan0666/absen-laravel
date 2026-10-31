<?php

namespace App\Services;

use App\Mail\PayrollStatusMail;
use App\Models\AuditLog;
use App\Models\Payroll;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

class PayrollService
{
    public function create(array $data): Payroll
    {
        $data = $this->normalize($data);
        $data['status_pembayaran'] = 'pending';

        $payroll = Payroll::create($data);
        $this->syncDetails($payroll, $data);

        AuditLog::record('payroll.created', $payroll, [], $payroll->fresh()->toArray());

        return $payroll;
    }

    public function update(Payroll $payroll, array $data): Payroll
    {
        $this->ensure(! $payroll->isPaid(), 'Paid payrolls are locked and cannot be edited.');

        $old = $payroll->toArray();

        $data = $this->normalize($data);
        unset($data['status_pembayaran']);

        $payroll->update($data);
        $this->syncDetails($payroll, $data);

        AuditLog::record('payroll.updated', $payroll, $old, $payroll->fresh()->toArray());

        return $payroll;
    }

    public function confirm(Payroll $payroll): void
    {
        $this->ensure($payroll->canBeConfirmed(), 'Payroll is already confirmed or paid.');

        $old = $this->workflowSnapshot($payroll);

        $payroll->update([
            'confirmed_by' => auth()->id(),
            'confirmed_at' => now(),
            'rejection_reason' => null,
        ]);

        AuditLog::record('payroll.confirmed', $payroll, $old, $this->workflowSnapshot($payroll));
        $this->queueStatusMail($payroll, 'confirmed');
    }

    public function reject(Payroll $payroll, string $reason): void
    {
        $this->ensure($payroll->canBeConfirmed(), 'Payroll is already confirmed or paid.');

        $old = $this->workflowSnapshot($payroll);

        $payroll->update([
            'confirmed_by' => auth()->id(),
            'confirmed_at' => null,
            'rejection_reason' => $reason,
        ]);

        AuditLog::record('payroll.rejected', $payroll, $old, $this->workflowSnapshot($payroll));
        $this->queueStatusMail($payroll, 'rejected');
    }

    public function markPaid(Payroll $payroll): void
    {
        $this->ensure($payroll->canBePaid(), 'Payroll must be confirmed before it can be marked as paid.');

        $old = $this->workflowSnapshot($payroll);

        $payroll->update([
            'status_pembayaran' => 'paid',
            'paid_at' => now(),
        ]);

        AuditLog::record('payroll.paid', $payroll, $old, $this->workflowSnapshot($payroll));
        $this->queueStatusMail($payroll, 'paid');
    }

    public function delete(Payroll $payroll): void
    {
        AuditLog::record('payroll.deleted', $payroll, $payroll->toArray(), []);

        $payroll->delete();
    }

    private function normalize(array $data): array
    {
        $data['total_lembur'] = $data['total_lembur'] ?? 0;
        $data['total_potongan'] = $data['total_potongan'] ?? 0;
        $data['bonus'] = $data['bonus'] ?? 0;
        $data['status_pembayaran'] = $data['status_pembayaran'] ?? 'pending';
        $data['total_gaji'] = $data['gaji_pokok']
            + $data['total_lembur']
            + $data['bonus']
            - $data['total_potongan'];

        return $data;
    }

    private function syncDetails(Payroll $payroll, array $data): void
    {
        $payroll->details()->delete();

        $details = [
            'base' => [$data['gaji_pokok'], 'Basic salary'],
            'overtime' => [$data['total_lembur'], 'Overtime pay'],
            'penalty' => [-$data['total_potongan'], 'Deductions'],
            'bonus' => [$data['bonus'], 'Bonus'],
        ];

        foreach ($details as $tipe => [$amount, $description]) {
            if ($amount == 0) {
                continue;
            }

            $payroll->details()->create([
                'tipe' => $tipe,
                'jumlah' => $amount,
                'deskripsi' => $description,
            ]);
        }
    }

    private function workflowSnapshot(Payroll $payroll): array
    {
        return [
            'status_pembayaran' => $payroll->status_pembayaran,
            'confirmed_by' => $payroll->confirmed_by,
            'confirmed_at' => $payroll->confirmed_at?->toDateTimeString(),
            'paid_at' => $payroll->paid_at?->toDateTimeString(),
            'rejection_reason' => $payroll->rejection_reason,
        ];
    }

    private function queueStatusMail(Payroll $payroll, string $status): void
    {
        $payroll->loadMissing('user');

        if ($payroll->user) {
            Mail::to($payroll->user)->queue(new PayrollStatusMail($payroll, $status));
        }
    }

    private function ensure(bool $condition, string $message): void
    {
        if (! $condition) {
            throw ValidationException::withMessages(['payroll' => $message]);
        }
    }
}
