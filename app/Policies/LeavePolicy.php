<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Leave;
use Illuminate\Auth\Access\HandlesAuthorization;

class LeavePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('leaves', 'view');
    }

    public function view(User $user, Leave $model): bool
    {
        if ($user->id === $model->user_id) {
            return true;
        }
        return $user->role && $user->role->hasPermission('leaves', 'view');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Leave $model): bool
    {
        if ($user->id === $model->user_id && $model->status === 'pending') {
            return true;
        }
        return $user->role && $user->role->hasPermission('leaves', 'approve');
    }

    public function delete(User $user, Leave $model): bool
    {
        return $user->id === $model->user_id && $model->status === 'pending';
    }

    public function approve(User $user, Leave $model): bool
    {
        return $user->role && $user->role->hasPermission('leaves', 'approve');
    }

    public function reject(User $user, Leave $model): bool
    {
        return $user->role && $user->role->hasPermission('leaves', 'approve');
    }
}