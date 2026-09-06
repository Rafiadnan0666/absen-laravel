<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register', [
            'departments' => \App\Models\Department::all(),
            'jobTitles' => \App\Models\JobTitle::all(),
            'roles' => \App\Models\Role::all(),
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $name = $request->input('name', $request->input('nama_lengkap'));

        if ($name !== null && ! $request->filled('nama_lengkap')) {
            $request->merge(['nama_lengkap' => $name]);
        }

        $departmentId = $request->input('department_id', \App\Models\Department::query()->value('id'));
        $jobTitleId = $request->input('job_title_id', \App\Models\JobTitle::query()->value('id'));
        $roleId = $request->input('role_id', \App\Models\Role::query()->value('id'));

        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'job_title_id' => ['sometimes', 'nullable', 'exists:job_titles,id'],
            'department_id' => ['sometimes', 'nullable', 'exists:departments,id'],
            'role_id' => ['sometimes', 'nullable', 'exists:roles,id'],
            'tipe_gaji' => ['sometimes', 'nullable', 'in:hourly,daily,monthly'],
            'jumlah_gaji' => ['sometimes', 'nullable', 'numeric', 'min:0'],
            'tanggal_masuk' => ['sometimes', 'nullable', 'date'],
        ]);

        $user = User::create([
            'name' => $name,
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'job_title_id' => $jobTitleId,
            'department_id' => $departmentId,
            'role_id' => $roleId,
            'tipe_gaji' => $request->input('tipe_gaji', 'monthly'),
            'jumlah_gaji' => $request->input('jumlah_gaji', 0),
            'tanggal_masuk' => $request->input('tanggal_masuk', now()->toDateString()),
            'status_akun' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        session()->put('show_tour', true);

        // Role-based redirect via the shared dashboard route
        return redirect(route('dashboard', absolute: false));
    }
}
