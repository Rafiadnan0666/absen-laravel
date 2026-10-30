<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $permissions = [
            // Leaves
            'leaves.view',
            'leaves.create',
            'leaves.approve',
            // Reimbursements
            'reimbursements.view',
            'reimbursements.create',
            'reimbursements.approve',
            // Attendances
            'attendances.view',
            'attendances.create',
            'attendances.update',
            'attendances.delete',
            // Users
            'users.view',
            'users.create',
            'users.update',
            'users.delete',
            // Departments
            'departments.view',
            'departments.create',
            'departments.update',
            'departments.delete',
            // Job Titles
            'job-titles.view',
            'job-titles.create',
            'job-titles.update',
            'job-titles.delete',
            // Shifts
            'shifts.view',
            'shifts.create',
            'shifts.update',
            'shifts.delete',
            // Locations
            'locations.view',
            'locations.create',
            'locations.update',
            'locations.delete',
            // Payrolls
            'payrolls.view',
            'payrolls.create',
            'payrolls.update',
            'payrolls.delete',
        ];

        foreach ($permissions as $perm) {
            Permission::updateOrCreate(
                ['nama_permission' => $perm],
                ['nama_permission' => $perm]
            );
        }

        // Assign permissions to roles
        $admin = Role::where('nama_role', 'admin')->first();
        $hr = Role::where('nama_role', 'hr')->first();
        $employee = Role::where('nama_role', 'employee')->first();

        // Admin gets all permissions
        if ($admin) {
            $admin->permissions()->sync(Permission::pluck('id'));
        }

        // HR gets view/create/approve for leaves, reimbursements, attendances, payrolls, users
        if ($hr) {
            $hrPermissions = Permission::whereIn('nama_permission', [
                'leaves.view', 'leaves.create', 'leaves.approve',
                'reimbursements.view', 'reimbursements.create', 'reimbursements.approve',
                'attendances.view', 'attendances.create', 'attendances.update',
                'payrolls.view',
                'users.view',
            ])->pluck('id');
            $hr->permissions()->sync($hrPermissions);
        }

        // Employee gets view/create for their own leaves, reimbursements, attendances
        if ($employee) {
            $employeePermissions = Permission::whereIn('nama_permission', [
                'leaves.view', 'leaves.create',
                'reimbursements.view', 'reimbursements.create',
                'attendances.view', 'attendances.create',
                'payrolls.view',
            ])->pluck('id');
            $employee->permissions()->sync($employeePermissions);
        }
    }
}