@extends('admin.dashboard.layout')

@section('title', 'Create Leave - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h2 class="text-xl font-bold uppercase tracking-wide">Create Leave Request</h2>
    </div>

    <form action="{{ route('admin.leaves.store') }}" method="POST">
      @csrf
      <div class="space-y-4">
        <div class="neo-form-group">
          <label for="user_id" class="neo-label">Employee</label>
          <select id="user_id" name="user_id" required class="neo-select">
            <option value="">Select Employee</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
            @endforeach
          </select>
          @error('user_id')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="tipe_cuti" class="neo-label">Leave Type</label>
          <select id="tipe_cuti" name="tipe_cuti" required class="neo-select">
            <option value="">Select Type</option>
            <option value="sick" {{ old('tipe_cuti') == 'sick' ? 'selected' : '' }}>Sick Leave</option>
            <option value="annual" {{ old('tipe_cuti') == 'annual' ? 'selected' : '' }}>Annual Leave</option>
            <option value="unpaid" {{ old('tipe_cuti') == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
          </select>
          @error('tipe_cuti')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="tanggal_mulai" class="neo-label">Start Date</label>
          <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai') }}" required class="neo-input">
          @error('tanggal_mulai')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="tanggal_selesai" class="neo-label">End Date</label>
          <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai') }}" required class="neo-input">
          @error('tanggal_selesai')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="alasan" class="neo-label">Reason</label>
          <textarea id="alasan" name="alasan" rows="4" class="neo-input" placeholder="Enter reason for leave" required>{{ old('alasan') }}</textarea>
          @error('alasan')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="flex justify-end mt-6 space-x-2">
        <a href="{{ route('admin.leaves.index') }}" class="neo-btn-secondary">
          Cancel
        </a>
        <button type="submit" class="neo-btn-primary">
          Create
        </button>
      </div>
    </form>
  </div>
</div>
@endsection