<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Location;
use Illuminate\Auth\Access\HandlesAuthorization;

class LocationPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->role && $user->role->hasPermission('locations', 'view');
    }

    public function view(User $user, Location $model): bool
    {
        return $user->role && $user->role->hasPermission('locations', 'view');
    }

    public function create(User $user): bool
    {
        return $user->role && $user->role->hasPermission('locations', 'create');
    }

    public function update(User $user, Location $model): bool
    {
        return $user->role && $user->role->hasPermission('locations', 'update');
    }

    public function delete(User $user, Location $model): bool
    {
        return $user->role && $user->role->hasPermission('locations', 'delete');
    }
}