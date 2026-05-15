@extends('auth.layout')

@section('title', 'Register - ABS')

@section('header', 'Create Account')

@section('content')
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-2">
            <label for="nama_lengkap" class="inline-block mb-1 text-xs font-bold text-slate-700">Full Name</label>
            <input id="nama_lengkap" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Full name">
            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1" />
        </div>

        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <label for="department_id" class="inline-block mb-1 text-xs font-bold text-slate-700">Department</label>
                <select id="department_id" name="department_id" required
                    class="focus:shadow-soft-primary-outline text-xs leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                    <option value="">Dept</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nama_department }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('department_id')" class="mt-1" />
            </div>
            <div>
                <label for="job_title_id" class="inline-block mb-1 text-xs font-bold text-slate-700">Job Title</label>
                <select id="job_title_id" name="job_title_id" required
                    class="focus:shadow-soft-primary-outline text-xs leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                    <option value="">Title</option>
                    @foreach($jobTitles as $job)
                        <option value="{{ $job->id }}" {{ old('job_title_id') == $job->id ? 'selected' : '' }}>{{ $job->nama_jabatan }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('job_title_id')" class="mt-1" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <label for="tipe_gaji" class="inline-block mb-1 text-xs font-bold text-slate-700">Salary Type</label>
                <select id="tipe_gaji" name="tipe_gaji" required
                    class="focus:shadow-soft-primary-outline text-xs leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                    <option value="">Type</option>
                    <option value="hourly" {{ old('tipe_gaji') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                    <option value="daily" {{ old('tipe_gaji') == 'daily' ? 'selected' : '' }}>Daily</option>
                    <option value="monthly" {{ old('tipe_gaji') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                </select>
                <x-input-error :messages="$errors->get('tipe_gaji')" class="mt-1" />
            </div>
            <div>
                <label for="jumlah_gaji" class="inline-block mb-1 text-xs font-bold text-slate-700">Salary</label>
                <input id="jumlah_gaji" type="number" step="0.01" name="jumlah_gaji" :value="old('jumlah_gaji')" required
                    class="focus:shadow-soft-primary-outline text-xs leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                    placeholder="Amount">
                <x-input-error :messages="$errors->get('jumlah_gaji')" class="mt-1" />
            </div>
        </div>

        <div class="grid grid-cols-2 gap-2 mb-2">
            <div>
                <label for="tanggal_masuk" class="inline-block mb-1 text-xs font-bold text-slate-700">Join Date</label>
                <input id="tanggal_masuk" type="date" name="tanggal_masuk" :value="old('tanggal_masuk', date('Y-m-d'))" required
                    class="focus:shadow-soft-primary-outline text-xs leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-1" />
            </div>
            <div>
                <label for="role_id" class="inline-block mb-1 text-xs font-bold text-slate-700">Role</label>
                <select id="role_id" name="role_id" required
                    class="focus:shadow-soft-primary-outline text-xs leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-2 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
                    <option value="">Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('role_id')" class="mt-1" />
            </div>
        </div>

        <div class="mb-2">
            <label for="no_hp" class="inline-block mb-1 text-xs font-bold text-slate-700">Phone (optional)</label>
            <input id="no_hp" type="text" name="no_hp" :value="old('no_hp')"
                class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                placeholder="Phone number">
            <x-input-error :messages="$errors->get('no_hp')" class="mt-1" />
        </div>

        <div class="grid grid-cols-2 gap-2 mb-3">
            <div>
                <label for="password" class="inline-block mb-1 text-xs font-bold text-slate-700">Password</label>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                    placeholder="Password">
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>
            <div>
                <label for="password_confirmation" class="inline-block mb-1 text-xs font-bold text-slate-700">Confirm</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                    class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-1.5 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
                    placeholder="Confirm">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <div class="flex items-center justify-between mt-2">
            <a href="{{ route('login') }}" class="text-xs font-bold text-slate-700 hover:underline">
                Already registered?
            </a>
            <button type="submit" class="inline-block px-4 py-2 text-xs font-bold uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
                Register
            </button>
        </div>
    </form>
@endsection
