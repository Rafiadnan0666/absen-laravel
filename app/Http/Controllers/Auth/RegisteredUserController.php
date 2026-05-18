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
        $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'job_title_id' => ['required', 'exists:job_titles,id'],
            'department_id' => ['required', 'exists:departments,id'],
            'role_id' => ['required', 'exists:roles,id'],
            'tipe_gaji' => ['required', 'in:hourly,daily,monthly'],
            'jumlah_gaji' => ['required', 'numeric', 'min:0'],
            'tanggal_masuk' => ['required', 'date'],
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'no_hp' => $request->no_hp,
            'job_title_id' => $request->job_title_id,
            'department_id' => $request->department_id,
            'role_id' => $request->role_id,
            'tipe_gaji' => $request->tipe_gaji,
            'jumlah_gaji' => $request->jumlah_gaji,
            'tanggal_masuk' => $request->tanggal_masuk ?? now()->toDateString(),
            'status_akun' => 'active',
        ]);

        event(new Registered($user));

        Auth::login($user);

        session()->put('show_tour', true);

        if ($user->role->nama_role === 'admin') {
            return redirect(route('admin.dashboard', absolute: false));
        } elseif ($user->role->nama_role === 'hr') {
            return redirect(route('hr.dashboard', absolute: false));
        } else {
            return redirect(route('employee.dashboard', absolute: false));
        }
    }
}
