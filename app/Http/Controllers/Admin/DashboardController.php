<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Payroll;
use App\Models\Department;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalEmployees = User::whereHas('role', function($query) {
            $query->where('nama_role', 'employee');
        })->count();
        $totalDepartments = Department::count();
        $totalLeaves = Leave::count();

        return view('admin.dashboard.index', compact('totalUsers', 'totalEmployees', 'totalDepartments', 'totalLeaves'));
    }
}
