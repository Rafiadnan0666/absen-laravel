@extends('admin.dashboard.layout')

@section('title', 'Edit Payroll Detail - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card p-6">
    <div class="mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">EDIT PAYROLL DETAIL #{{ $payrollDetail->id }}</h6>
    </div>

    @if($errors->any())
    <div class="neo-alert-danger mb-6">
      <ul class="list-disc pl-4">
        @foreach($errors->all() as $err)<li>{{ $err }}</li>@endforeach
      </ul>
    </div>
    @endif

    <form action="{{ route('admin.payroll-details.update', $payrollDetail) }}" method="POST">
      @csrf @method('PUT')

      <div class="mb-4">
        <label class="neo-label" for="payroll_id">PAYROLL</label>
        <select id="payroll_id" name="payroll_id" required class="neo-select">
          <option value="">SELECT PAYROLL</option>
          @foreach($payrolls as $payroll)
            <option value="{{ $payroll->id }}" {{ old('payroll_id', $payrollDetail->payroll_id) == $payroll->id ? 'selected' : '' }}>
              {{ $payroll->user->nama_lengkap ?? 'N/A' }} - {{ $payroll->periode_mulai->format('d M Y') }} to {{ $payroll->periode_selesai->format('d M Y') }}
            </option>
          @endforeach
        </select>
      </div>

      <div class="mb-4">
        <label class="neo-label" for="tipe">TYPE</label>
        <select id="tipe" name="tipe" required class="neo-select">
          <option value="">SELECT TYPE</option>
          <option value="base" {{ old('tipe', $payrollDetail->tipe) == 'base' ? 'selected' : '' }}>BASE SALARY</option>
          <option value="overtime" {{ old('tipe', $payrollDetail->tipe) == 'overtime' ? 'selected' : '' }}>OVERTIME</option>
          <option value="penalty" {{ old('tipe', $payrollDetail->tipe) == 'penalty' ? 'selected' : '' }}>PENALTY</option>
          <option value="bonus" {{ old('tipe', $payrollDetail->tipe) == 'bonus' ? 'selected' : '' }}>BONUS</option>
        </select>
      </div>

      <div class="mb-4">
        <label class="neo-label" for="jumlah">AMOUNT</label>
        <input type="number" step="0.01" min="0" id="jumlah" name="jumlah" value="{{ old('jumlah', $payrollDetail->jumlah) }}" placeholder="0.00" required class="neo-input">
      </div>

      <div class="mb-4">
        <label class="neo-label" for="deskripsi">DESCRIPTION</label>
        <textarea id="deskripsi" name="deskripsi" rows="3" class="neo-input" placeholder="Optional description">{{ old('deskripsi', $payrollDetail->deskripsi) }}</textarea>
      </div>

      <div class="flex justify-end gap-2">
        <a href="{{ route('admin.payroll-details.index') }}" class="neo-btn-secondary">CANCEL</a>
        <button type="submit" class="neo-btn-primary">UPDATE</button>
      </div>
    </form>
  </div>
</div>
@endsection
