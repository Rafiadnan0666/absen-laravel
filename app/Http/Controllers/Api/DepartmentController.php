<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::withCount('users')->paginate($request->per_page ?? 15);

        return response()->json($departments);
    }

    public function show(Department $department)
    {
        $department->loadCount('users');

        return response()->json($department);
    }
}
