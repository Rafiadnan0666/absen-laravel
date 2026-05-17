@extends('auth.layout')

@section('title', 'Register - ABS')
@section('subtitle', 'Create account')

@section('content')
<form method="POST" action="{{ route('register') }}">
@csrf

<div class="neo-form-group">
<label for="nama_lengkap" class="neo-label">Full Name</label>
<input type="text" name="nama_lengkap" id="nama_lengkap" value="{{ old('nama_lengkap') }}" required autofocus placeholder="Your name" class="neo-input">
@error('nama_lengkap')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="neo-form-group">
<label for="email" class="neo-label">Email</label>
<input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="email@example.com" class="neo-input">
@error('email')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="neo-form-group">
<label for="department_id" class="neo-label">Department</label>
<select name="department_id" id="department_id" required class="neo-select">
<option value="">Select</option>
@foreach($departments as $dept)
<option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->nama_department }}</option>
@endforeach
</select>
@error('department_id')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="neo-form-group">
<label for="job_title_id" class="neo-label">Job Title</label>
<select name="job_title_id" id="job_title_id" required class="neo-select">
<option value="">Select</option>
@foreach($jobTitles as $job)
<option value="{{ $job->id }}" {{ old('job_title_id') == $job->id ? 'selected' : '' }}>{{ $job->nama_jabatan }}</option>
@endforeach
</select>
@error('job_title_id')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="grid grid-cols-2 gap-3 mb-3">
<div class="neo-form-group">
<label for="role_id" class="neo-label">Role</label>
<select name="role_id" id="role_id" required class="neo-select">
<option value="">Role</option>
@foreach($roles as $role)
<option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
@endforeach
</select>
@error('role_id')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>
<div class="neo-form-group">
<label for="tanggal_masuk" class="neo-label">Join Date</label>
<input type="date" name="tanggal_masuk" id="tanggal_masuk" value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required class="neo-input">
@error('tanggal_masuk')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>
</div>

<div class="grid grid-cols-2 gap-3 mb-3">
<div class="neo-form-group">
<label for="tipe_gaji" class="neo-label">Salary Type</label>
<select name="tipe_gaji" id="tipe_gaji" required class="neo-select">
<option value="">Type</option>
<option value="hourly" {{ old('tipe_gaji') == 'hourly' ? 'selected' : '' }}>Hourly</option>
<option value="daily" {{ old('tipe_gaji') == 'daily' ? 'selected' : '' }}>Daily</option>
<option value="monthly" {{ old('tipe_gaji') == 'monthly' ? 'selected' : '' }}>Monthly</option>
</select>
@error('tipe_gaji')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>
<div class="neo-form-group">
<label for="jumlah_gaji" class="neo-label">Salary</label>
<input type="number" step="0.01" name="jumlah_gaji" id="jumlah_gaji" value="{{ old('jumlah_gaji') }}" required placeholder="0.00" class="neo-input">
@error('jumlah_gaji')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>
</div>

<div class="neo-form-group">
<label for="no_hp" class="neo-label">Phone (Optional)</label>
<input type="text" name="no_hp" id="no_hp" value="{{ old('no_hp') }}" placeholder="Phone" class="neo-input">
@error('no_hp')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>

<div class="grid grid-cols-2 gap-3 mb-4">
<div class="neo-form-group">
<label for="password" class="neo-label">Password</label>
<input type="password" name="password" id="password" required autocomplete="new-password" placeholder="••••" class="neo-input">
@error('password')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>
<div class="neo-form-group">
<label for="password_confirmation" class="neo-label">Confirm</label>
<input type="password" name="password_confirmation" id="password_confirmation" required autocomplete="new-password" placeholder="••••" class="neo-input">
@error('password_confirmation')<div class="neo-alert-danger mt-2 py-2 px-3 text-sm">{{ $message }}</div>@enderror
</div>
</div>

<button type="submit" class="neo-btn-primary w-full"><i class="fas fa-user-plus"></i> Create Account</button>
</form>

@section('footer')
<p class="text-center">Have account? <a href="{{ route('login') }}" class="neo-link"><strong>Sign in</strong></a></p>
@endsection
@endsection