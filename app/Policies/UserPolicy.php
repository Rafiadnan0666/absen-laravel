<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('users', 'view');
    }

    public function view(User $user, User $model): bool
    {
        return $user->role && $user->role->hasPermission('users', 'view');
    }

    public function create(User $user): bool
    {
        return $user->role && $user->role->hasPermission('users', 'create');
    }

    public function update(User $user, User $model): bool
    {
        return $user->role && $user->role->hasPermission('users', 'update');
    }

    public function delete(User $user, User $model): bool
    {
        return $user->role && $user->role->hasPermission('users', 'delete');
    }
}