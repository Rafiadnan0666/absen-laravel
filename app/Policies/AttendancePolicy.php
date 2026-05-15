<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Attendance;
use Illuminate\Auth\Access\HandlesAuthorization;

class AttendancePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('attendances', 'view');
    }

    public function view(User $user, Attendance $model): bool
    {
        if ($user->id === $model->user_id) {
            return true;
        }
        return $user->role && $user->role->hasPermission('attendances', 'view');
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Attendance $model): bool
    {
        return $user->role && $user->role->hasPermission('attendances', 'update');
    }

    public function delete(User $user, Attendance $model): bool
    {
        return $user->role && $user->role->hasPermission('attendances', 'delete');
    }
}