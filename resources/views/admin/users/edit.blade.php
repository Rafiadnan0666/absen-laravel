@extends('admin.dashboard.layout')

@section('title', 'Edit Employee - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <div class="flex items-center mb-0">
        <a href="{{ route('admin.users.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
        <h6 class="text-xl font-bold">Edit: {{ strtoupper($user->nama_lengkapp) }}</h6>
      </div>
    </div>
    <div>
      <form action="{{ route('admin.users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
          <label for="nama_lengkap" class="neo-label">Full Name</label>
          <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
            class="neo-input"
            placeholder="Enter full name" required>
          @error('nama_lengkap')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="email" class="neo-label">Email</label>
          <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
            class="neo-input"
            placeholder="Enter email" required>
          @error('email')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="no_hp" class="neo-label">Phone</label>
          <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
            class="neo-input"
            placeholder="Enter phone number">
          @error('no_hp')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="alamat" class="neo-label">Address</label>
          <textarea id="alamat" name="alamat" rows="3"
            class="neo-input"
            placeholder="Enter address">{{ old('alamat', $user->alamat) }}</textarea>
          @error('alamat')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="department_id" class="neo-label">Department</label>
          <select id="department_id" name="department_id" required
            class="neo-select">
            <option value="">Select Department</option>
            @foreach($departments as $dept)
              <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->nama_department }}</option>
            @endforeach
          </select>
          @error('department_id')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="job_title_id" class="neo-label">Job Title</label>
          <select id="job_title_id" name="job_title_id" required
            class="neo-select">
            <option value="">Select Job Title</option>
            @foreach($jobTitles as $job)
              <option value="{{ $job->id }}" {{ old('job_title_id', $user->job_title_id) == $job->id ? 'selected' : '' }}>{{ $job->nama_jabatan }}</option>
            @endforeach
          </select>
          @error('job_title_id')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="role_id" class="neo-label">Role</label>
          <select id="role_id" name="role_id" required
            class="neo-select">
            <option value="">Select Role</option>
            @foreach($roles as $role)
              <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
            @endforeach
          </select>
          @error('role_id')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="tipe_gaji" class="neo-label">Salary Type</label>
          <select id="tipe_gaji" name="tipe_gaji" required
            class="neo-select">
            <option value="">Select Type</option>
            <option value="hourly" {{ old('tipe_gaji', $user->tipe_gaji) == 'hourly' ? 'selected' : '' }}>Hourly</option>
            <option value="daily" {{ old('tipe_gaji', $user->tipe_gaji) == 'daily' ? 'selected' : '' }}>Daily</option>
            <option value="monthly" {{ old('tipe_gaji', $user->tipe_gaji) == 'monthly' ? 'selected' : '' }}>Monthly</option>
          </select>
          @error('tipe_gaji')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="jumlah_gaji" class="neo-label">Salary Amount</label>
          <input type="number" step="0.01" id="jumlah_gaji" name="jumlah_gaji" value="{{ old('jumlah_gaji', $user->jumlah_gaji) }}"
            class="neo-input"
            placeholder="Enter salary amount" required>
          @error('jumlah_gaji')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="mb-4">
          <label for="status_akun" class="neo-label">Status</label>
          <select id="status_akun" name="status_akun" required
            class="neo-select">
            <option value="active" {{ old('status_akun', $user->status_akun) == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status_akun', $user->status_akun) == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          @error('status_akun')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex justify-end">
          <a href="{{ route('admin.users.index') }}" class="neo-btn-secondary">
            Cancel
          </a>
          <button type="submit" class="neo-btn-primary">
            Update Employee
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection