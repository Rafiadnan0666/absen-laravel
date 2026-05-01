<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Nama Lengkap -->
        <div>
            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
            <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap')" required autofocus />
            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- No HP -->
        <div class="mt-4">
            <x-input-label for="no_hp" :value="__('No HP')" />
            <x-text-input id="no_hp" class="block mt-1 w-full" type="text" name="no_hp" :value="old('no_hp')" />
            <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
        </div>

        <!-- Department -->
        <div class="mt-4">
            <x-input-label for="department_id" :value="__('Department')" />
            <select id="department_id" name="department_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">-- Pilih Department --</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nama_department }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('department_id')" class="mt-2" />
        </div>

        <!-- Job Title -->
        <div class="mt-4">
            <x-input-label for="job_title_id" :value="__('Job Title')" />
            <select id="job_title_id" name="job_title_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">-- Pilih Job Title --</option>
                @foreach($jobTitles as $job)
                    <option value="{{ $job->id }}" {{ old('job_title_id') == $job->id ? 'selected' : '' }}>{{ $job->nama_jabatan }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('job_title_id')" class="mt-2" />
        </div>

        <!-- Role -->
        <div class="mt-4">
            <x-input-label for="role_id" :value="__('Role')" />
            <select id="role_id" name="role_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">-- Pilih Role --</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                @endforeach
            </select>
            <x-input-error :messages="$errors->get('role_id')" class="mt-2" />
        </div>

        <!-- Tipe Gaji -->
        <div class="mt-4">
            <x-input-label for="tipe_gaji" :value="__('Tipe Gaji')" />
            <select id="tipe_gaji" name="tipe_gaji" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                <option value="">-- Pilih Tipe Gaji --</option>
                <option value="hourly" {{ old('tipe_gaji') == 'hourly' ? 'selected' : '' }}>Hourly</option>
                <option value="daily" {{ old('tipe_gaji') == 'daily' ? 'selected' : '' }}>Daily</option>
                <option value="monthly" {{ old('tipe_gaji') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
            <x-input-error :messages="$errors->get('tipe_gaji')" class="mt-2" />
        </div>

        <!-- Jumlah Gaji -->
        <div class="mt-4">
            <x-input-label for="jumlah_gaji" :value="__('Jumlah Gaji')" />
            <x-text-input id="jumlah_gaji" class="block mt-1 w-full" type="number" step="0.01" name="jumlah_gaji" :value="old('jumlah_gaji')" required />
            <x-input-error :messages="$errors->get('jumlah_gaji')" class="mt-2" />
        </div>

        <!-- Tanggal Masuk -->
        <div class="mt-4">
            <x-input-label for="tanggal_masuk" :value="__('Tanggal Masuk')" />
            <x-text-input id="tanggal_masuk" class="block mt-1 w-full" type="date" name="tanggal_masuk" :value="old('tanggal_masuk', date('Y-m-d'))" required />
            <x-input-error :messages="$errors->get('tanggal_masuk')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
