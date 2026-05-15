<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Auth\Access\HandlesAuthorization;

class ShiftPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('shifts', 'view');
    }

    public function view(User $user, Shift $model): bool
    {
        return $user->role && $user->role->hasPermission('shifts', 'view');
    }

    public function create(User $user): bool
    {
        return $user->role && $user->role->hasPermission('shifts', 'create');
    }

    public function update(User $user, Shift $model): bool
    {
        return $user->role && $user->role->hasPermission('shifts', 'update');
    }

    public function delete(User $user, Shift $model): bool
    {
        return $user->role && $user->role->hasPermission('shifts', 'delete');
    }
}