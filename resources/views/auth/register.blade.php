@extends('auth.layout')

@section('title', 'Register - ABS')

@section('header', 'Create Account')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Full Name -->
        <div class="mb-4">
            <label for="nama_lengkap" class="inline-block mb-2 text-sm font-bold text-slate-700">Full Name</label>
            <input id="nama_lengkap" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter your full name">
            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mb-4">
            <label for="email" class="inline-block mb-2 text-sm font-bold text-slate-700">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autocomplete="username"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter your email">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone -->
        <div class="mb-4">
            <label for="no_hp" class="inline-block mb-2 text-sm font-bold text-slate-700">Phone Number</label>
            <input id="no_hp" type="text" name="no_hp" :value="old('no_hp')"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter your phone number">
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <!-- Department -->
        <div class="mb-4">
            <label for="department_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Department</label>
            <select id="department_id" name="department_id" required
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nama_department }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
        </div>

        <!-- Job Title -->
        <div class="mb-4">
            <label for="job_title_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Job Title</label>
            <select id="job_title_id" name="job_title_id" required
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                <option value="">Select Job Title</option>
                @foreach($jobTitles as $job)
                    <option value="{{ $job->id }}" {{ old('job_title_id') == $job->id ? 'selected' : '' }}>{{ $job->nama_jabatan }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('job_title_id')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mb-4">
            <label for="role_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Role</label>
            <select id="role_id" name="role_id" required
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- Salary Type -->
        <div class="mb-4">
            <label for="tipe_gaji" class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Type</label>
            <select id="tipe_gaji" name="tipe_gaji" required
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                <option value="">Select Salary Type</option>
                <option value="hourly" {{ old('tipe_gaji') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                <option value="daily" {{ old('tipe_gaji') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ old('tipe_gaji') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
            <x-input-error :messages="$errors->get('tipe_gaji')" class="mt-2" />
        </div>

        <!-- Salary Amount -->
        <div class="mb-4">
            <label for="jumlah_gaji" class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Amount</label>
            <input id="jumlah_gaji" type="number" step="0.01" name="jumlah_gaji" :value="old('jumlah_gaji')" required
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Enter salary amount">
            <x-input-error :messages="$errors->get('jumlah_gaji')" class="mt-2" />
        </div>

        <!-- Join Date -->
        <div class="mb-4">
            <label for="tanggal_masuk" class="inline-block mb-2 text-sm font-bold text-slate-700">Join Date</label>
            <input id="tanggal_masuk" type="date" name="tanggal_masuk" :value="old('tanggal_masuk', date('Y-m-d'))" required
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="inline-block mb-2 text-sm font-bold text-slate-700">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Create a password">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-6">
            <label for="password_confirmation" class="inline-block mb-2 text-sm font-bold text-slate-700">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Confirm your password">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-4">
            <a href="{{ route('login') }}" class="text-sm font-bold text-slate-700 hover:underline">
                {{ __('Already registered?') }}
            </a>

            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
                {{ __('Register') }}
            </button>
        </div>
    </form>
@endsection
