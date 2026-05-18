<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Department;
use App\Models\JobTitle;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::with(['department', 'jobTitle', 'role']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%");
            });
        }

        if ($request->filled('filterStatus')) {
            $query->where('status_akun', $request->filterStatus);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        $users = $query->paginate($request->per_page ?? 15);

        return response()->json($users);
    }

    public function show(User $user)
    {
        return response()->json($user->load(['department', 'jobTitle', 'role', 'shifts']));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'department_id' => 'required|exists:departments,id',
            'job_title_id' => 'required|exists:job_titles,id',
            'role_id' => 'required|exists:roles,id',
            'tipe_gaji' => 'required|in:hourly,daily,monthly',
            'jumlah_gaji' => 'required|numeric|min:0',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['status_akun'] = 'active';
        $user = User::create($validated);

        return response()->json($user->load('department', 'jobTitle', 'role'), 201);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . $user->id,
            'department_id' => 'sometimes|exists:departments,id',
            'job_title_id' => 'sometimes|exists:job_titles,id',
            'role_id' => 'sometimes|exists:roles,id',
            'status_akun' => 'sometimes|in:active,inactive',
        ]);

        $user->update($validated);

        return response()->json($user->load('department', 'jobTitle', 'role'));
    }

    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'User deleted']);
    }
}
