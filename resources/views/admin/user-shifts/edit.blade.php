@extends('admin.dashboard.layout')

@section('title', 'Edit User Shift - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6">
      <h6 class="text-xl font-bold">EDIT USER SHIFT</h6>
    </div>
    <form action="{{ route('admin.user-shifts.update', $userShift) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="neo-form-group">
        <label for="user_id" class="neo-label">Employee</label>
        <select id="user_id" name="user_id" required class="neo-select">
          <option value="">Select Employee</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $userShift->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
          @endforeach
        </select>
        @error('user_id')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="neo-form-group">
        <label for="shift_id" class="neo-label">Shift</label>
        <select id="shift_id" name="shift_id" required class="neo-select">
          <option value="">Select Shift</option>
          @foreach($shifts as $shift)
            <option value="{{ $shift->id }}" {{ old('shift_id', $userShift->shift_id) == $shift->id ? 'selected' : '' }}>{{ $shift->nama_shift }} ({{ $shift->jam_mulai }} - {{ $shift->jam_selesai }})</option>
          @endforeach
        </select>
        @error('shift_id')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="neo-form-group">
        <label for="tanggal_shift" class="neo-label">Date</label>
        <input type="date" id="tanggal_shift" name="tanggal_shift" value="{{ old('tanggal_shift', $userShift->tanggal_shift->format('Y-m-d')) }}" required class="neo-input">
        @error('tanggal_shift')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>
      <div class="flex justify-end">
        <a href="{{ route('admin.user-shifts.index') }}" class="neo-btn-secondary mr-2">CANCEL</a>
        <button type="submit" class="neo-btn-primary">UPDATE</button>
      </div>
    </form>
  </div>
</div>
@endsection