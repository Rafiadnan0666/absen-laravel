@extends('admin.dashboard.layout')

@section('title', 'Edit Employee - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex items-center mb-0">
          <a href="{{ route('admin.users.index') }}" class="inline-block px-6 py-3 mb-0 mr-4 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
          <h6 class="text-xl font-bold">Edit: {{ strtoupper($user->nama_lengkap) }}</h6>
        </div>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="nama_lengkap" class="inline-block mb-2 text-sm font-bold text-slate-700">Full Name</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter full name" required>
            @error('nama_lengkap')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="email" class="inline-block mb-2 text-sm font-bold text-slate-700">Email</label>
            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter email" required>
            @error('email')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="no_hp" class="inline-block mb-2 text-sm font-bold text-slate-700">Phone</label>
            <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp', $user->no_hp) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter phone number">
            @error('no_hp')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="alamat" class="inline-block mb-2 text-sm font-bold text-slate-700">Address</label>
            <textarea id="alamat" name="alamat" rows="3"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter address">{{ old('alamat', $user->alamat) }}</textarea>
            @error('alamat')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="department_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Department</label>
            <select id="department_id" name="department_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Department</option>
              @foreach($departments as $dept)
                <option value="{{ $dept->id }}" {{ old('department_id', $user->department_id) == $dept->id ? 'selected' : '' }}>{{ $dept->nama_department }}</option>
              @endforeach
            </select>
            @error('department_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="job_title_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Job Title</label>
            <select id="job_title_id" name="job_title_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Job Title</option>
              @foreach($jobTitles as $job)
                <option value="{{ $job->id }}" {{ old('job_title_id', $user->job_title_id) == $job->id ? 'selected' : '' }}>{{ $job->nama_jabatan }}</option>
              @endforeach
            </select>
            @error('job_title_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="role_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Role</label>
            <select id="role_id" name="role_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Role</option>
              @foreach($roles as $role)
                <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
              @endforeach
            </select>
            @error('role_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="tipe_gaji" class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Type</label>
            <select id="tipe_gaji" name="tipe_gaji" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Type</option>
              <option value="hourly" {{ old('tipe_gaji', $user->tipe_gaji) == 'hourly' ? 'selected' : '' }}>Hourly</option>
              <option value="daily" {{ old('tipe_gaji', $user->tipe_gaji) == 'daily' ? 'selected' : '' }}>Daily</option>
              <option value="monthly" {{ old('tipe_gaji', $user->tipe_gaji) == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
            @error('tipe_gaji')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="jumlah_gaji" class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Amount</label>
            <input type="number" step="0.01" id="jumlah_gaji" name="jumlah_gaji" value="{{ old('jumlah_gaji', $user->jumlah_gaji) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter salary amount" required>
            @error('jumlah_gaji')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="status_akun" class="inline-block mb-2 text-sm font-bold text-slate-700">Status</label>
            <select id="status_akun" name="status_akun" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="active" {{ old('status_akun', $user->status_akun) == 'active' ? 'selected' : '' }}>Active</option>
              <option value="inactive" {{ old('status_akun', $user->status_akun) == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
            @error('status_akun')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>

          <div class="flex justify-end">
            <a href="{{ route('admin.users.index') }}" class="inline-block px-6 py-3 mb-0 mr-2 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
              Cancel
            </a>
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
              Update Employee
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
