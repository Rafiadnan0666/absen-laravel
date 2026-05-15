<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Department;
use Illuminate\Auth\Access\HandlesAuthorization;

class DepartmentPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('departments', 'view');
    }

    public function view(User $user, Department $model): bool
    {
        return $user->role && $user->role->hasPermission('departments', 'view');
    }

    public function create(User $user): bool
    {
        return $user->role && $user->role->hasPermission('departments', 'create');
    }

    public function update(User $user, Department $model): bool
    {
        return $user->role && $user->role->hasPermission('departments', 'update');
    }

    public function delete(User $user, Department $model): bool
    {
        return $user->role && $user->role->hasPermission('departments', 'delete');
    }
}