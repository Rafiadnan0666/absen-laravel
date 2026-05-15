<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Reimbursement;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReimbursementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('reimbursements', 'view');
    }

    public function view(User $user, Reimbursement $model): bool
    {
        if ($user->id === $model->user_id) {
            return true;
        }
        return $user->role && $user->role->hasPermission('reimbursements', 'view');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Reimbursement $model): bool
    {
        if ($user->id === $model->user_id && $model->status === 'pending') {
            return true;
        }
        return $user->role && $user->role->hasPermission('reimbursements', 'approve');
    }

    public function delete(User $user, Reimbursement $model): bool
    {
        return $user->id === $model->user_id && $model->status === 'pending';
    }

    public function approve(User $user, Reimbursement $model): bool
    {
        return $user->role && $user->role->hasPermission('reimbursements', 'approve');
    }

    public function reject(User $user, Reimbursement $model): bool
    {
        return $user->role && $user->role->hasPermission('reimbursements', 'approve');
    }
}