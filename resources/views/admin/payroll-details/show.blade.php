@extends('admin.dashboard.layout')

@section('title', 'Payroll Detail - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card p-6">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">PAYROLL DETAIL #{{ $payrollDetail->id }}</h6>
      <div class="flex gap-2">
        <a href="{{ route('admin.payroll-details.edit', $payrollDetail) }}" class="neo-btn-secondary">EDIT</a>
        <a href="{{ route('admin.payroll-details.index') }}" class="neo-btn-secondary">BACK</a>
      </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
      <div class="mb-4">
        <label class="neo-label">PAYROLL</label>
        <p class="text-sm font-bold">{{ $payrollDetail->payroll->user->nama_lengkap ?? 'N/A' }}</p>
        <p class="text-xs">{{ $payrollDetail->payroll->periode_mulai->format('d M Y') }} - {{ $payrollDetail->payroll->periode_selesai->format('d M Y') }}</p>
      </div>

      <div class="mb-4">
        <label class="neo-label">TYPE</label>
        <span class="neo-badge">{{ ucfirst($payrollDetail->tipe) }}</span>
      </div>

      <div class="mb-4">
        <label class="neo-label">AMOUNT</label>
        <p class="text-2xl font-black">Rp {{ number_format($payrollDetail->jumlah, 2, ',', '.') }}</p>
      </div>

      <div class="mb-4">
        <label class="neo-label">DESCRIPTION</label>
        <p class="text-sm">{{ $payrollDetail->deskripsi ?? 'No description' }}</p>
      </div>

      <div class="mb-4">
        <label class="neo-label">CREATED AT</label>
        <p class="text-sm">{{ $payrollDetail->created_at->format('d M Y H:i') }}</p>
      </div>

      <div class="mb-4">
        <label class="neo-label">UPDATED AT</label>
        <p class="text-sm">{{ $payrollDetail->updated_at->format('d M Y H:i') }}</p>
      </div>
    </div>

    <div class="flex justify-end mt-6 border-t-3 border-black pt-4">
      <form action="{{ route('admin.payroll-details.destroy', $payrollDetail) }}" method="POST" onsubmit="return confirm('Delete this payroll detail?')">
        @csrf @method('DELETE')
        <button type="submit" class="neo-btn-danger">DELETE</button>
      </form>
    </div>
  </div>
</div>
@endsection
