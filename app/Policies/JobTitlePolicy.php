<?php

namespace App\Policies;

use App\Models\User;
use App\Models\JobTitle;
use Illuminate\Auth\Access\HandlesAuthorization;

class JobTitlePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('job-titles', 'view');
    }

    public function view(User $user, JobTitle $model): bool
    {
        return $user->role && $user->role->hasPermission('job-titles', 'view');
    }

    public function create(User $user): bool
    {
        return $user->role && $user->role->hasPermission('job-titles', 'create');
    }

    public function update(User $user, JobTitle $model): bool
    {
        return $user->role && $user->role->hasPermission('job-titles', 'update');
    }

    public function delete(User $user, JobTitle $model): bool
    {
        return $user->role && $user->role->hasPermission('job-titles', 'delete');
    }
}