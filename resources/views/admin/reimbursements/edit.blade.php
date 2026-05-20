@extends('admin.dashboard.layout')

@section('title', 'Edit Reimbursement - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">EDIT REIMBURSEMENT</h6>
    </div>

    <form action="{{ route('admin.reimbursements.update', $reimbursement) }}" method="POST">
      @csrf
      @method('PUT')

      <div class="mb-4">
        <label for="user_id" class="neo-label">EMPLOYEE</label>
        <select id="user_id" name="user_id" required class="neo-select">
          <option value="">SELECT EMPLOYEE</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $reimbursement->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
          @endforeach
        </select>
        @error('user_id')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="kategori" class="neo-label">CATEGORY</label>
        <select id="kategori" name="kategori" required class="neo-select">
          <option value="">SELECT CATEGORY</option>
          <option value="transport" {{ old('kategori', $reimbursement->kategori) == 'transport' ? 'selected' : '' }}>TRANSPORTATION</option>
          <option value="medical" {{ old('kategori', $reimbursement->kategori) == 'medical' ? 'selected' : '' }}>MEDICAL</option>
          <option value="meal" {{ old('kategori', $reimbursement->kategori) == 'meal' ? 'selected' : '' }}>MEAL</option>
          <option value="supplies" {{ old('kategori', $reimbursement->kategori) == 'supplies' ? 'selected' : '' }}>OFFICE SUPPLIES</option>
          <option value="training" {{ old('kategori', $reimbursement->kategori) == 'training' ? 'selected' : '' }}>TRAINING</option>
          <option value="other" {{ old('kategori', $reimbursement->kategori) == 'other' ? 'selected' : '' }}>OTHER</option>
        </select>
        @error('kategori')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="jumlah" class="neo-label">AMOUNT</label>
        <input type="number" step="0.01" id="jumlah" name="jumlah" value="{{ old('jumlah', $reimbursement->jumlah) }}" class="neo-input" placeholder="ENTER AMOUNT" required>
        @error('jumlah')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="deskripsi" class="neo-label">DESCRIPTION</label>
        <textarea id="deskripsi" name="deskripsi" rows="4" class="neo-input" placeholder="ENTER DESCRIPTION" required>{{ old('deskripsi', $reimbursement->deskripsi) }}</textarea>
        @error('deskripsi')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <label for="status" class="neo-label">STATUS</label>
        <select id="status" name="status" required class="neo-select">
          <option value="pending" {{ old('status', $reimbursement->status) == 'pending' ? 'selected' : '' }}>PENDING</option>
          <option value="approved" {{ old('status', $reimbursement->status) == 'approved' ? 'selected' : '' }}>APPROVED</option>
          <option value="rejected" {{ old('status', $reimbursement->status) == 'rejected' ? 'selected' : '' }}>REJECTED</option>
        </select>
        @error('status')
          <p class="text-neo-red text-sm mt-1 font-bold">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end space-x-2">
        <a href="{{ route('admin.reimbursements.index') }}" class="neo-btn-secondary">
          CANCEL
        </a>
        <button type="submit" class="neo-btn-primary">
          UPDATE
        </button>
      </div>
    </form>
  </div>
</div>
@endsection