@extends('admin.dashboard.layout')

@section('title', 'Edit Leave - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Edit Leave Request</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.leaves.update', $leave) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="user_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Employee</label>
            <select id="user_id" name="user_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Employee</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $leave->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
              @endforeach
            </select>
            @error('user_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="tipe_cuti" class="inline-block mb-2 text-sm font-bold text-slate-700">Leave Type</label>
            <select id="tipe_cuti" name="tipe_cuti" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Type</option>
              <option value="sick" {{ old('tipe_cuti', $leave->tipe_cuti) == 'sick' ? 'selected' : '' }}>Sick Leave</option>
              <option value="annual" {{ old('tipe_cuti', $leave->tipe_cuti) == 'annual' ? 'selected' : '' }}>Annual Leave</option>
              <option value="unpaid" {{ old('tipe_cuti', $leave->tipe_cuti) == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
            </select>
            @error('tipe_cuti')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="tanggal_mulai" class="inline-block mb-2 text-sm font-bold text-slate-700">Start Date</label>
            <input type="date" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', $leave->tanggal_mulai->format('Y-m-d')) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              required>
            @error('tanggal_mulai')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="tanggal_selesai" class="inline-block mb-2 text-sm font-bold text-slate-700">End Date</label>
            <input type="date" id="tanggal_selesai" name="tanggal_selesai" value="{{ old('tanggal_selesai', $leave->tanggal_selesai->format('Y-m-d')) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              required>
            @error('tanggal_selesai')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="alasan" class="inline-block mb-2 text-sm font-bold text-slate-700">Reason</label>
            <textarea id="alasan" name="alasan" rows="4"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter reason for leave" required>{{ old('alasan', $leave->alasan) }}</textarea>
            @error('alasan')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="status_pengajuan" class="inline-block mb-2 text-sm font-bold text-slate-700">Status</label>
            <select id="status_pengajuan" name="status_pengajuan" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="pending" {{ old('status_pengajuan', $leave->status_pengajuan) == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="approved" {{ old('status_pengajuan', $leave->status_pengajuan) == 'approved' ? 'selected' : '' }}>Approved</option>
              <option value="rejected" {{ old('status_pengajuan', $leave->status_pengajuan) == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status_pengajuan')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <a href="{{ route('admin.leaves.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white mr-2">
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
