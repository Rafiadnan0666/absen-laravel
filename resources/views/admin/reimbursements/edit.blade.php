@extends('admin.dashboard.layout')

@section('title', 'Edit Reimbursement - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Edit Reimbursement</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.reimbursements.update', $reimbursement) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="user_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Employee</label>
            <select id="user_id" name="user_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Employee</option>
              @foreach($users as $user)
                <option value="{{ $user->id }}" {{ old('user_id', $reimbursement->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
              @endforeach
            </select>
            @error('user_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="jumlah" class="inline-block mb-2 text-sm font-bold text-slate-700">Amount</label>
            <input type="number" step="0.01" id="jumlah" name="jumlah" value="{{ old('jumlah', $reimbursement->jumlah) }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter amount" required>
            @error('jumlah')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="deskripsi" class="inline-block mb-2 text-sm font-bold text-slate-700">Description</label>
            <textarea id="deskripsi" name="deskripsi" rows="4"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter description" required>{{ old('deskripsi', $reimbursement->deskripsi) }}</textarea>
            @error('deskripsi')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="status" class="inline-block mb-2 text-sm font-bold text-slate-700">Status</label>
            <select id="status" name="status" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="pending" {{ old('status', $reimbursement->status) == 'pending' ? 'selected' : '' }}>Pending</option>
              <option value="approved" {{ old('status', $reimbursement->status) == 'approved' ? 'selected' : '' }}>Approved</option>
              <option value="rejected" {{ old('status', $reimbursement->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <a href="{{ route('admin.reimbursements.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white mr-2">
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
