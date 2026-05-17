@extends('admin.dashboard.layout')

@section('title', 'Create Employee - Admin')

@section('content')
<h1 class="neo-section-title">ADD EMPLOYEE</h1>

<div class="neo-card">
    <div class="flex items-center mb-6">
        <a href="{{ route('admin.users.index') }}" class="neo-btn-secondary neo-btn-sm mr-4">BACK</a>
    </div>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf
        <div class="neo-form-group">
            <label for="nama_lengkap" class="neo-label">FULL NAME</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap') }}" class="neo-input" placeholder="Enter full name" required autofocus>
            @error('nama_lengkap')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="neo-form-group">
            <label for="email" class="neo-label">EMAIL</label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" class="neo-input" placeholder="Enter email" required>
            @error('email')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="neo-form-group">
            <label for="password" class="neo-label">PASSWORD</label>
            <input type="password" id="password" name="password" class="neo-input" placeholder="Enter password" required>
            @error('password')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="neo-form-group">
            <label for="no_hp" class="neo-label">PHONE</label>
            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" class="neo-input" placeholder="Enter phone">
        </div>

        <div class="neo-form-group">
            <label for="department_id" class="neo-label">DEPARTMENT</label>
            <select id="department_id" name="department_id" class="neo-select">
                <option value="">Select Department</option>
                @foreach($departments as $dept)
                    <option value="{{ $dept->id }}">{{ $dept->nama_department }}</option>
                @endforeach
            </select>
        </div>

        <div class="neo-form-group">
            <label for="job_title_id" class="neo-label">JOB TITLE</label>
            <select id="job_title_id" name="job_title_id" class="neo-select">
                <option value="">Select Job Title</option>
                @foreach($jobTitles as $job)
                    <option value="{{ $job->id }}">{{ $job->nama_jabatan }}</option>
                @endforeach
            </select>
        </div>

        <div class="neo-form-group">
            <label for="role_id" class="neo-label">ROLE</label>
            <select id="role_id" name="role_id" class="neo-select">
                <option value="">Select Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                @endforeach
            </select>
        </div>

        <div class="neo-form-group">
            <label for="tanggal_masuk" class="neo-label">JOIN DATE</label>
            <input type="date" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" class="neo-input">
        </div>

        <div class="neo-form-group">
            <label for="jumlah_gaji" class="neo-label">SALARY</label>
            <input type="number" id="jumlah_gaji" name="jumlah_gaji" value="{{ old('jumlah_gaji') }}" class="neo-input" placeholder="Enter salary">
        </div>

        <div class="neo-form-group">
            <label for="tipe_gaji" class="neo-label">SALARY TYPE</label>
            <select id="tipe_gaji" name="tipe_gaji" class="neo-select">
                <option value="bulanan">Monthly</option>
                <option value="harian">Daily</option>
            </select>
        </div>

        <div class="neo-form-group">
            <label for="status_akun" class="neo-label">STATUS</label>
            <select id="status_akun" name="status_akun" class="neo-select">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="neo-btn-primary">SAVE</button>
            <a href="{{ route('admin.users.index') }}" class="neo-btn-secondary">CANCEL</a>
        </div>
    </form>
</div>
@endsection