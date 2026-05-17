@extends('auth.layout')

@section('title', 'Register - ABS')
@section('subtitle', 'Create account')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-2">
            <label for="nama_lengkap" class="block text-xs font-bold text-black mb-1">Full Name</label>
            <input id="nama_lengkap" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus
                class="input-field"
                placeholder="Your name">
            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="mb-2">
            <label for="email" class="block text-xs font-bold text-black mb-1">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required
                class="input-field"
                placeholder="email@example.com">
            <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="mb-2">
            <label for="department_id" class="block text-xs font-bold text-black mb-1">Department</label>
            <select id="department_id" name="department_id" required class="input-field">
                <option value="">Select</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nama_department }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="mb-2">
            <label for="job_title_id" class="block text-xs font-bold text-black mb-1">Job Title</label>
            <select id="job_title_id" name="job_title_id" required class="input-field">
                <option value="">Select</option>
                @foreach($jobTitles as $job)
                    <option value="{{ $job->id }}" {{ old('job_title_id') == $job->id ? 'selected' : '' }}>{{ $job->nama_jabatan }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('job_title_id')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <label for="role_id" class="block text-xs font-bold text-black mb-1">Role</label>
                <select id="role_id" name="role_id" required class="input-field text-xs">
                    <option value="">Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role_id')" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
                <label for="tanggal_masuk" class="block text-xs font-bold text-black mb-1">Join Date</label>
                <input id="tanggal_masuk" type="date" name="tanggal_masuk" :value="old('tanggal_masuk', date('Y-m-d'))" required class="input-field text-xs">
                <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-1 text-xs text-red-500" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <label for="tipe_gaji" class="block text-xs font-bold text-black mb-1">Salary Type</label>
                <select id="tipe_gaji" name="tipe_gaji" required class="input-field text-xs">
                    <option value="">Type</option>
                    <option value="hourly" {{ old('tipe_gaji') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                    <option value="daily" {{ old('tipe_gaji') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="monthly" {{ old('tipe_gaji') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
                <x-input-error :messages="$errors->get('tipe_gaji')" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
                <label for="jumlah_gaji" class="block text-xs font-bold text-black mb-1">Salary</label>
                <input id="jumlah_gaji" type="number" step="0.01" name="jumlah_gaji" :value="old('jumlah_gaji')" required class="input-field text-xs" placeholder="0.00">
                <x-input-error :messages="$errors->get('jumlah_gaji')" class="mt-1 text-xs text-red-500" />
            </div>
        </div>

        <div class="mb-2">
            <label for="no_hp" class="block text-xs font-bold text-black mb-1">Phone (Optional)</label>
            <input id="no_hp" type="text" name="no_hp" :value="old('no_hp')" class="input-field" placeholder="Phone">
            <x-input-error :messages="$errors->get('no_hp')" class="mt-1 text-xs text-red-500" />
        </div>

        <div class="grid grid-cols-2 gap-2 mb-3">
            <div>
                <label for="password" class="block text-xs font-bold text-black mb-1">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password" class="input-field text-xs" placeholder="••••">
                <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-red-500" />
            </div>
            <div>
                <label for="password_confirmation" class="block text-xs font-bold text-black mb-1">Confirm</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="input-field text-xs" placeholder="••••">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1 text-xs text-red-500" />
            </div>
        </div>

        <button type="submit" class="btn-primary w-full">
            <i class="fas fa-user-plus mr-1"></i>Create Account
        </button>
    </form>

    @section('footer')
        <p class="text-center text-xs text-slate-600">
            Have account?
            <a href="{{ route('login') }}" class="font-bold text-black hover:underline">
                Sign in
            </a>
        </p>
    @endsection
@endsection