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
    public function index(Request $request)
    {
        $query = User::with(['department', 'jobTitle', 'role']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhereHas('department', fn($q) => $q->where('nama_department', 'like', "%{$s}%"))
                  ->orWhereHas('role', fn($q) => $q->where('nama_role', 'like', "%{$s}%"));
            });
        }

        if ($request->filled('filterStatus')) {
            $query->where('status_akun', $request->filterStatus);
        }

        if ($request->filled('filterDept')) {
            $query->where('department_id', $request->filterDept);
        }

        if ($request->filled('filterRole')) {
            $query->where('role_id', $request->filterRole);
        }

        $users = $query->paginate(10)->withQueryString();
        $departments = Department::all();
        $roles = Role::all();

        if ($request->ajax()) {
            return view('admin.users._table', compact('users'))->render();
        }

        $totalUsers = User::count();
        $activeUsers = User::where('status_akun', 'active')->count();
        $inactiveUsers = User::where('status_akun', 'inactive')->count();
        $employeeCount = User::whereHas('role', fn($q) => $q->where('nama_role', 'employee'))->count();

        return view('admin.users.index', compact(
            'users', 'departments', 'roles',
            'totalUsers', 'activeUsers', 'inactiveUsers', 'employeeCount'
        ));
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

    public function export(Request $request)
    {
        $query = User::with(['department', 'jobTitle', 'role']);

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhereHas('department', fn($q) => $q->where('nama_department', 'like', "%{$s}%"))
                  ->orWhereHas('role', fn($q) => $q->where('nama_role', 'like', "%{$s}%"));
            });
        }
        if ($request->filled('filterStatus')) {
            $query->where('status_akun', $request->filterStatus);
        }
        if ($request->filled('filterDept')) {
            $query->where('department_id', $request->filterDept);
        }
        if ($request->filled('filterRole')) {
            $query->where('role_id', $request->filterRole);
        }

        $users = $query->get();

        $filename = 'users-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($users) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Department', 'Job Title', 'Role', 'Salary Type', 'Salary', 'Join Date', 'Status']);

            foreach ($users as $u) {
                fputcsv($handle, [
                    $u->id,
                    $u->nama_lengkap,
                    $u->email,
                    $u->no_hp ?? '-',
                    $u->department->nama_department ?? 'N/A',
                    $u->jobTitle->nama_jabatan ?? 'N/A',
                    $u->role->nama_role ?? 'N/A',
                    $u->tipe_gaji ?? '-',
                    $u->jumlah_gaji ?? 0,
                    $u->tanggal_masuk ? $u->tanggal_masuk->format('Y-m-d') : '-',
                    $u->status_akun,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
