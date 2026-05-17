@extends('admin.dashboard.layout')

@section('title', 'Edit Attendance - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">EDIT ATTENDANCE RECORD</h6>
    </div>

    <form action="{{ route('admin.attendances.update', $attendance) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="neo-form-group">
        <label for="user_id" class="neo-label">Employee</label>
        <select id="user_id" name="user_id" required class="neo-select">
          <option value="">Select Employee</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $attendance->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
          @endforeach
        </select>
        @error('user_id')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="tanggal" class="neo-label">Date</label>
        <input type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', $attendance->tanggal->format('Y-m-d')) }}" required class="neo-input">
        @error('tanggal')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="check_in" class="neo-label">Check In</label>
        <input type="time" id="check_in" name="check_in" value="{{ old('check_in', $attendance->check_in ? $attendance->check_in->format('H:i') : '') }}" class="neo-input">
        @error('check_in')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="check_out" class="neo-label">Check Out</label>
        <input type="time" id="check_out" name="check_out" value="{{ old('check_out', $attendance->check_out ? $attendance->check_out->format('H:i') : '') }}" class="neo-input">
        @error('check_out')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="status_hadir" class="neo-label">Status</label>
        <select id="status_hadir" name="status_hadir" required class="neo-select">
          <option value="">Select Status</option>
          <option value="present" {{ old('status_hadir', $attendance->status_hadir) == 'present' ? 'selected' : '' }}>Present</option>
          <option value="late" {{ old('status_hadir', $attendance->status_hadir) == 'late' ? 'selected' : '' }}>Late</option>
          <option value="absent" {{ old('status_hadir', $attendance->status_hadir) == 'absent' ? 'selected' : '' }}>Absent</option>
        </select>
        @error('status_hadir')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="jam_kerja" class="neo-label">Work Hours</label>
        <input type="time" id="jam_kerja" name="jam_kerja" value="{{ old('jam_kerja', $attendance->jam_kerja ? $attendance->jam_kerja->format('H:i') : '') }}" class="neo-input">
        @error('jam_kerja')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="jam_lembur" class="neo-label">Overtime Hours</label>
        <input type="time" id="jam_lembur" name="jam_lembur" value="{{ old('jam_lembur', $attendance->jam_lembur ? $attendance->jam_lembur->format('H:i') : '') }}" class="neo-input">
        @error('jam_lembur')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="menit_telat" class="neo-label">Late Minutes</label>
        <input type="number" id="menit_telat" name="menit_telat" value="{{ old('menit_telat', $attendance->menit_telat) }}" placeholder="Enter late minutes" min="0" class="neo-input">
        @error('menit_telat')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="menit_pulang_cepat" class="neo-label">Early Leave Minutes</label>
        <input type="number" id="menit_pulang_cepat" name="menit_pulang_cepat" value="{{ old('menit_pulang_cepat', $attendance->menit_pulang_cepat) }}" placeholder="Enter early leave minutes" min="0" class="neo-input">
        @error('menit_pulang_cepat')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label for="location_id" class="neo-label">Location</label>
        <select id="location_id" name="location_id" class="neo-select">
          <option value="">Select Location</option>
          @foreach($locations as $location)
            <option value="{{ $location->id }}" {{ old('location_id', $attendance->location_id) == $location->id ? 'selected' : '' }}>{{ $location->nama_lokasi }}</option>
          @endforeach
        </select>
        @error('location_id')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="neo-form-group">
        <label class="neo-label">Face Verified</label>
        <div class="flex items-center gap-2 mt-2">
          <input type="checkbox" id="face_verified" name="face_verified" value="1" {{ old('face_verified', $attendance->face_verified) ? 'checked' : '' }} class="neo-checkbox">
          <label for="face_verified" class="text-sm font-bold">Yes, face was verified</label>
        </div>
        @error('face_verified')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex gap-2 mt-6">
        <a href="{{ route('admin.attendances.index') }}" class="neo-btn-secondary">Cancel</a>
        <button type="submit" class="neo-btn-primary">Update</button>
      </div>
    </form>
  </div>
</div>
@endsection