<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::withCount(['users', 'permissions'])->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        $permissions = Permission::orderBy('nama_permission')->get();
        return view('admin.roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role',
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['nama_role' => $validated['nama_role']]);
        if (!empty($validated['permissions'])) {
            $role->permissions()->attach($validated['permissions']);
        }

        return redirect()->route('admin.roles.index')->with('success', 'Role created');
    }

    public function show(Request $request, Role $role)
    {
        $users = $role->users()->paginate(10);
        $role->load('permissions');
        return view('admin.roles.show', compact('role', 'users'));
    }

    public function edit(Role $role)
    {
        $permissions = Permission::orderBy('nama_permission')->get();
        $role->load('permissions');
        return view('admin.roles.edit', compact('role', 'permissions'));
    }

    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'nama_role' => 'required|string|max:255|unique:roles,nama_role,' . $role->id,
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role->update(['nama_role' => $validated['nama_role']]);
        $role->permissions()->sync($validated['permissions'] ?? []);

        return redirect()->route('admin.roles.index')->with('success', 'Role updated');
    }

    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', 'Role deleted');
    }
}
