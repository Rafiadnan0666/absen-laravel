<?php

namespace App\Services;

use App\Mail\LeaveStatusMail;
use App\Mail\ReimbursementStatusMail;
use App\Models\AuditLog;
use App\Models\Leave;
use App\Models\Reimbursement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ApprovalService
{
    public function approve(Model $record, string $statusColumn = 'status', ?string $approverColumn = 'approved_by'): void
    {
        $this->transition($record, 'approved', $statusColumn, $approverColumn);
    }

    public function reject(Model $record, string $statusColumn = 'status', ?string $approverColumn = 'approved_by'): void
    {
        $this->transition($record, 'rejected', $statusColumn, $approverColumn);
    }

    private function transition(Model $record, string $status, string $statusColumn, ?string $approverColumn): void
    {
        $old = $this->snapshot($record, $statusColumn, $approverColumn);

        $attributes = [$statusColumn => $status];
        if ($approverColumn !== null) {
            $attributes[$approverColumn] = auth()->id();
        }

        $record->update($attributes);

        AuditLog::record($this->actionName($record, $status), $record, $old, $attributes);
        $this->queueStatusMail($record, $status);
    }

    private function snapshot(Model $record, string $statusColumn, ?string $approverColumn): array
    {
        $snapshot = [$statusColumn => $record->getAttribute($statusColumn)];

        if ($approverColumn !== null) {
            $snapshot[$approverColumn] = $record->getAttribute($approverColumn);
        }

        return $snapshot;
    }

    private function actionName(Model $record, string $status): string
    {
        return Str::snake(class_basename($record)).'.'.$status;
    }

    private function queueStatusMail(Model $record, string $status): void
    {
        $record->loadMissing('user');
        $user = $record->user;

        if (! $user) {
            return;
        }

        $mailable = match (true) {
            $record instanceof Leave => new LeaveStatusMail($record, $status),
            $record instanceof Reimbursement => new ReimbursementStatusMail($record, $status),
            default => null,
        };

        if ($mailable !== null) {
            Mail::to($user)->queue($mailable);
        }
    }
}
