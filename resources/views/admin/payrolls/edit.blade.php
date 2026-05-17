@extends('admin.dashboard.layout')

@section('title', 'Edit Payroll - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card p-6">
    <div class="mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">Edit Payroll</h6>
    </div>

    <form action="{{ route('admin.payrolls.update', $payroll) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <neo-label for="user_id">Employee</neo-label>
        <neo-select id="user_id" name="user_id" required>
          <option value="">Select Employee</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ old('user_id', $payroll->user_id) == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }} ({{ $user->email }})</option>
          @endforeach
        </neo-select>
        @error('user_id')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="periode_mulai">Start Period</neo-label>
        <neo-input type="date" id="periode_mulai" name="periode_mulai" value="{{ old('periode_mulai', $payroll->periode_mulai->format('Y-m-d')) }}" required></neo-input>
        @error('periode_mulai')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="periode_selesai">End Period</neo-label>
        <neo-input type="date" id="periode_selesai" name="periode_selesai" value="{{ old('periode_selesai', $payroll->periode_selesai->format('Y-m-d')) }}" required></neo-input>
        @error('periode_selesai')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="gaji_pokok">Base Salary</neo-label>
        <neo-input type="number" step="0.01" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok', $payroll->gaji_pokok) }}" placeholder="Enter base salary" required></neo-input>
        @error('gaji_pokok')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="total_lembur">Overtime Pay</neo-label>
        <neo-input type="number" step="0.01" id="total_lembur" name="total_lembur" value="{{ old('total_lembur', $payroll->total_lembur) }}" placeholder="Enter overtime pay"></neo-input>
        @error('total_lembur')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="total_potongan">Deductions</neo-label>
        <neo-input type="number" step="0.01" id="total_potongan" name="total_potongan" value="{{ old('total_potongan', $payroll->total_potongan) }}" placeholder="Enter deductions"></neo-input>
        @error('total_potongan')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="bonus">Bonus</neo-label>
        <neo-input type="number" step="0.01" id="bonus" name="bonus" value="{{ old('bonus', $payroll->bonus) }}" placeholder="Enter bonus"></neo-input>
        @error('bonus')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="total_gaji">Total Salary</neo-label>
        <neo-input type="number" step="0.01" id="total_gaji" name="total_gaji" value="{{ old('total_gaji', $payroll->total_gaji) }}" placeholder="Enter total salary" required></neo-input>
        @error('total_gaji')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="mb-4">
        <neo-label for="status_pembayaran">Payment Status</neo-label>
        <neo-select id="status_pembayaran" name="status_pembayaran" required>
          <option value="">Select Status</option>
          <option value="pending" {{ old('status_pembayaran', $payroll->status_pembayaran) == 'pending' ? 'selected' : '' }}>Pending</option>
          <option value="paid" {{ old('status_pembayaran', $payroll->status_pembayaran) == 'paid' ? 'selected' : '' }}>Paid</option>
        </neo-select>
        @error('status_pembayaran')
          <p class="text-neo-red text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      <div class="flex justify-end mt-6">
        <a href="{{ route('admin.payrolls.index') }}" class="neo-btn-secondary mr-2">
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