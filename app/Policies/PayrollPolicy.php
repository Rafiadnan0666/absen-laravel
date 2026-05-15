<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Payroll;
use Illuminate\Auth\Access\HandlesAuthorization;

class PayrollPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('payrolls', 'view');
    }

    public function view(User $user, Payroll $model): bool
    {
        if ($user->id === $model->user_id) {
            return true;
        }
        return $user->role && $user->role->hasPermission('payrolls', 'view');
    }

    public function create(User $user): bool
    {
        return $user->role && $user->role->hasPermission('payrolls', 'create');
    }

    public function update(User $user, Payroll $model): bool
    {
        return $user->role && $user->role->hasPermission('payrolls', 'update');
    }

    public function delete(User $user, Payroll $model): bool
    {
        return $user->role && $user->role->hasPermission('payrolls', 'delete');
    }
}