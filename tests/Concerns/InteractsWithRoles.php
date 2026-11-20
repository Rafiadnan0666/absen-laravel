<?php

namespace Tests\Concerns;

use App\Models\Role;
use App\Models\User;

trait InteractsWithRoles
{
    protected function seedRoles(): void
    {
        $this->seed(\Database\Seeders\RoleSeeder::class);
        $this->seed(\Database\Seeders\DepartmentSeeder::class);
        $this->seed(\Database\Seeders\JobTitleSeeder::class);
        $this->seed(\Database\Seeders\ShiftSeeder::class);
    }

    protected function createUserWithRole(string $role): User
    {
        $roleModel = Role::where('nama_role', $role)->firstOrFail();

        return User::factory()->create(['role_id' => $roleModel->id]);
    }

    protected function createEmployee(): User
    {
        return $this->createUserWithRole('employee');
    }

    protected function createHR(): User
    {
        return $this->createUserWithRole('hr');
    }

    protected function createAdmin(): User
    {
        return $this->createUserWithRole('admin');
    }
}