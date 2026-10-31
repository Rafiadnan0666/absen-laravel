<?php

namespace App\Http\Controllers\Concerns;

use App\Services\ApprovalService;
use Illuminate\Database\Eloquent\Model;

/**
 * Shared approval workflow for records that expose an approval status
 * column and an optional approver column.
 */
trait HandlesApproval
{
    protected function approveRecord(Model $record, string $statusColumn = 'status', ?string $approverColumn = 'approved_by'): void
    {
        app(ApprovalService::class)->approve($record, $statusColumn, $approverColumn);
    }

    protected function rejectRecord(Model $record, string $statusColumn = 'status', ?string $approverColumn = 'approved_by'): void
    {
        app(ApprovalService::class)->reject($record, $statusColumn, $approverColumn);
    }
}
