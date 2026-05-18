<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('users')->paginate(10);
        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        return view('admin.departments.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_department' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        Department::create($validated);
        return redirect()->route('admin.departments.index')->with('success', 'Department created');
    }

    public function show(Request $request, Department $department)
    {
        $users = $department->users()->paginate(10);
        return view('admin.departments.show', compact('department', 'users'));
    }

    public function edit(Department $department)
    {
        return view('admin.departments.edit', compact('department'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'nama_department' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $department->update($validated);
        return redirect()->route('admin.departments.index')->with('success', 'Department updated');
    }

    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('admin.departments.index')->with('success', 'Department deleted');
    }
}
