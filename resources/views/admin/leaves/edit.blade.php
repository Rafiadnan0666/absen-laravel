@extends('admin.dashboard.layout')

@section('title', 'Edit Leave - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h2 class="text-xl font-bold uppercase tracking-wide">Edit Leave Request</h2>
    </div>

    <form action="{{ route('admin.leaves.update', $leave) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="space-y-4">
        <div class="neo-form-group">
          <label for="user_id" class="neo-label">Employee</label>
          <select id="user_id" name="user_id" required class="neo-select">
            <option value="">Select Employee</option>
            @foreach($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id', $leave->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
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
            <option value="sick" {{ old('tipe_cuti', $leave->tipe_cuti) == 'sick' ? 'selected' : '' }}>Sick Leave</option>
            <option value="annual" {{ old('tipe_cuti', $leave->tipe_cuti) == 'annual' ? 'selected' : '' }}>Annual Leave</option>
            <option value="unpaid" {{ old('tipe_cuti', $leave->tipe_cuti) == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
          </select>
          @error('tipe_cuti')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="tanggal_mulai" class="neo-label">Start Date</label>
          <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $leave->tanggal_mulai->format('Y-m-d')) }}" required class="neo-input">
          @error('tanggal_mulai')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="tanggal_selesai" class="neo-label">End Date</label>
          <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $leave->tanggal_selesai->format('Y-m-d')) }}" required class="neo-input">
          @error('tanggal_selesai')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="alasan" class="neo-label">Reason</label>
          <textarea id="alasan" name="alasan" rows="4" class="neo-input" placeholder="Enter reason for leave" required>{{ old('alasan', $leave->alasan) }}</textarea>
          @error('alasan')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
        <div class="neo-form-group">
          <label for="status_pengajuan" class="neo-label">Status</label>
          <select id="status_pengajuan" name="status_pengajuan" required class="neo-select">
            <option value="pending" {{ old('status_pengajuan', $leave->status_pengajuan) == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ old('status_pengajuan', $leave->status_pengajuan) == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ old('status_pengajuan', $leave->status_pengajuan) == 'rejected' ? 'selected' : '' }}>Rejected</option>
          </select>
          @error('status_pengajuan')
            <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
          @enderror
        </div>
      </div>

      <div class="flex justify-end mt-6 space-x-2">
        <a href="{{ route('admin.leaves.index') }}" class="neo-btn-secondary">
          Cancel
        </a>
        <button type="submit" class="neo-btn-primary">
          Update
        </button>
      </div>
    </form>
  </div>
</div>
@endsection