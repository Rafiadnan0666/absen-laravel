<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;

/**
 * Shared approval workflow for records that expose an approval status
 * column and an optional approver column.
 */
trait HandlesApproval
{
    protected function approveRecord(Model $record, string $statusColumn = 'status', ?string $approverColumn = 'approved_by'): void
    {
        $record->update($this->approvalAttributes('approved', $statusColumn, $approverColumn));
    }

    protected function rejectRecord(Model $record, string $statusColumn = 'status', ?string $approverColumn = 'approved_by'): void
    {
        $record->update($this->approvalAttributes('rejected', $statusColumn, $approverColumn));
    }

    private function approvalAttributes(string $status, string $statusColumn, ?string $approverColumn): array
    {
        $attributes = [$statusColumn => $status];

        if ($approverColumn !== null) {
            $attributes[$approverColumn] = auth()->id();
        }

        return $attributes;
    }
}
