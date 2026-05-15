<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Shift;
use App\Models\Leave;
use App\Models\Attendance;
use App\Models\Location;
use App\Models\Reimbursement;
use App\Models\Payroll;
use App\Policies\UserPolicy;
use App\Policies\DepartmentPolicy;
use App\Policies\JobTitlePolicy;
use App\Policies\ShiftPolicy;
use App\Policies\LeavePolicy;
use App\Policies\AttendancePolicy;
use App\Policies\LocationPolicy;
use App\Policies\ReimbursementPolicy;
use App\Policies\PayrollPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Department::class => DepartmentPolicy::class,
        JobTitle::class => JobTitlePolicy::class,
        Shift::class => ShiftPolicy::class,
        Leave::class => LeavePolicy::class,
        Attendance::class => AttendancePolicy::class,
        Location::class => LocationPolicy::class,
        Reimbursement::class => ReimbursementPolicy::class,
        Payroll::class => PayrollPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        Gate::define('isAdmin', function (User $user) {
            return $user->role && $user->role->nama_role === 'Admin';
        });

        Gate::define('isHR', function (User $user) {
            return $user->role && $user->role->nama_role === 'HR';
        });

        Gate::define('isEmployee', function (User $user) {
            return $user->role && $user->role->nama_role === 'Employee';
        });
    }
}