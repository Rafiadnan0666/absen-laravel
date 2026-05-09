@extends('admin.dashboard.layout')

@section('title', 'Edit Attendance - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Edit Attendance Record</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.attendances.update', $attendance) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="user_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Employee</label>
            <select id="user_id" name="user_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Employee</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $attendance->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
              @endforeach
            </select>
            @error('user_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="tanggal" class="inline-block mb-2 text-sm font-bold text-slate-700">Date</label>
            <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $attendance->tanggal->format('Y-m-d')) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              required>
            @error('tanggal')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="check_in" class="inline-block mb-2 text-sm font-bold text-slate-700">Check In</label>
            <input type="time" id="check_in" name="check_in" value="{{ old('check_in', $attendance->check_in ? $attendance->check_in->format('H:i') : '') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
            @error('check_in')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="check_out" class="inline-block mb-2 text-sm font-bold text-slate-700">Check Out</label>
            <input type="time" id="check_out" name="check_out" value="{{ old('check_out', $attendance->check_out ? $attendance->check_out->format('H:i') : '') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
            @error('check_out')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="status_hadir" class="inline-block mb-2 text-sm font-bold text-slate-700">Status</label>
            <select id="status_hadir" name="status_hadir" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Status</option>
              <option value="present" {{ old('status_hadir', $attendance->status_hadir) == 'present' ? 'selected' : '' }}>Present</option>
              <option value="late" {{ old('status_hadir', $attendance->status_hadir) == 'late' ? 'selected' : '' }}>Late</option>
              <option value="absent" {{ old('status_hadir', $attendance->status_hadir) == 'absent' ? 'selected' : '' }}>Absent</option>
            </select>
            @error('status_hadir')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="jam_kerja" class="inline-block mb-2 text-sm font-bold text-slate-700">Work Hours</label>
            <input type="time" id="jam_kerja" name="jam_kerja" value="{{ old('jam_kerja', $attendance->jam_kerja ? $attendance->jam_kerja->format('H:i') : '') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
            @error('jam_kerja')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="jam_lembur" class="inline-block mb-2 text-sm font-bold text-slate-700">Overtime Hours</label>
            <input type="time" id="jam_lembur" name="jam_lembur" value="{{ old('jam_lembur', $attendance->jam_lembur ? $attendance->jam_lembur->format('H:i') : '') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
            @error('jam_lembur')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="menit_telat" class="inline-block mb-2 text-sm font-bold text-slate-700">Late Minutes</label>
            <input type="number" id="menit_telat" name="menit_telat" value="{{ old('menit_telat', $attendance->menit_telat) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter late minutes" min="0">
            @error('menit_telat')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="menit_pulang_cepat" class="inline-block mb-2 text-sm font-bold text-slate-700">Early Leave Minutes</label>
            <input type="number" id="menit_pulang_cepat" name="menit_pulang_cepat" value="{{ old('menit_pulang_cepat', $attendance->menit_pulang_cepat) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter early leave minutes" min="0">
            @error('menit_pulang_cepat')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="location_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Location</label>
            <select id="location_id" name="location_id"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Location</option>
              @foreach($locations as $location)
                <option value="{{ $location->id }}" {{ old('location_id', $attendance->location_id) == $location->id ? 'selected' : '' }}>{{ $location->nama_lokasi }}</option>
              @endforeach
            </select>
            @error('location_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label class="inline-block mb-2 text-sm font-bold text-slate-700">Face Verified</label>
            <div class="flex items-center">
              <input type="checkbox" id="face_verified" name="face_verified" value="1" {{ old('face_verified', $attendance->face_verified) ? 'checked' : '' }}
                class="w-4 h-4 text-fuchsia-600 bg-gray-100 border-gray-300 rounded focus:ring-fuchsia-500">
              <label for="face_verified" class="ml-2 text-sm text-slate-700">Yes, face was verified</label>
            </div>
            @error('face_verified')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <a href="{{ route('admin.attendances.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white mr-2">
              Cancel
            </a>
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
