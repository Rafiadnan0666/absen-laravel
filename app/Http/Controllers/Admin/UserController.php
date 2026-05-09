<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['department', 'jobTitle', 'role'])->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $departments = Department::all();
        $jobTitles = JobTitle::all();
        $roles = Role::all();
        return view('admin.users.create', compact('departments', 'jobTitles', 'roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'role_id' => 'required|exists:roles,id',
            'tipe_gaji' => 'required|in:hourly,daily,monthly',
            'jumlah_gaji' => 'required|numeric|min:0',
            'tanggal_masuk' => 'required|date',
        ]);

        $user = User::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'],
            'alamat' => $validated['alamat'],
            'department_id' => $validated['department_id'],
            'job_title_id' => $validated['job_title_id'],
            'role_id' => $validated['role_id'],
            'tipe_gaji' => $validated['tipe_gaji'],
            'jumlah_gaji' => $validated['jumlah_gaji'],
            'tanggal_masuk' => $validated['tanggal_masuk'],
            'status_akun' => 'active',
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit(User $user)
    {
        $departments = Department::all();
        $jobTitles = JobTitle::all();
        $roles = Role::all();
        return view('admin.users.edit', compact('user', 'departments', 'jobTitles', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'role_id' => 'required|exists:roles,id',
            'tipe_gaji' => 'required|in:hourly,daily,monthly',
            'jumlah_gaji' => 'required|numeric|min:0',
            'status_akun' => 'required|in:active,inactive',
        ]);

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully');
    }
}
