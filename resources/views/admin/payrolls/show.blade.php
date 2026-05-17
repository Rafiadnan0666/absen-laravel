@extends('admin.dashboard.layout')

@section('title', 'View Payroll - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">Payroll Details</h6>
      <a href="{{ route('admin.payrolls.index') }}" class="neo-btn-secondary">
        <i class="fas fa-arrow-left mr-1"></i> Back
      </a>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
      <div class="mb-4">
        <label class="neo-label">ID</label>
        <p class="font-bold">#{{ $payroll->id }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Employee</label>
        <p>{{ $payroll->user->nama_lengkap ?? 'N/A' }} ({{ $payroll->user->email ?? 'N/A' }})</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Period</label>
        <p>{{ $payroll->periode_mulai->format('d M Y') }} - {{ $payroll->periode_selesai->format('d M Y') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Base Salary</label>
        <p>Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Overtime Pay</label>
        <p class="text-neo-green">+ Rp {{ number_format($payroll->total_lembur ?? 0, 0, ',', '.') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Deductions</label>
        <p class="text-neo-red">- Rp {{ number_format($payroll->total_potongan ?? 0, 0, ',', '.') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Bonus</label>
        <p>Rp {{ number_format($payroll->bonus ?? 0, 0, ',', '.') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Total Salary</label>
        <p class="font-bold text-lg">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Payment Status</label>
        <span class="neo-badge {{ $payroll->status_pembayaran == 'paid' ? 'neo-badge-green' : 'neo-badge-yellow' }}">
          {{ strtoupper($payroll->status_pembayaran) }}
        </span>
      </div>
    </div>

    @if($payroll->details && $payroll->details->count() > 0)
    <div class="mt-6">
      <label class="neo-label">Payroll Details</label>
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>Description</th>
            <th>Amount</th>
            <th>Type</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payroll->details as $detail)
          <tr>
            <td>{{ $detail->deskripsi }}</td>
            <td>Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
            <td>
              <span class="neo-badge {{ $detail->tipe == 'allowance' ? 'neo-badge-green' : 'neo-badge-red' }}">
                {{ ucfirst($detail->tipe) }}
              </span>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif

    <div class="flex justify-end mt-6">
      <a href="{{ route('admin.payrolls.edit', $payroll) }}" class="neo-btn-cyan mr-2">
        <i class="fas fa-edit mr-1"></i> Edit
      </a>
      <form action="{{ route('admin.payrolls.destroy', $payroll) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="neo-btn-danger">
          <i class="fas fa-trash mr-1"></i> Delete
        </button>
      </form>
    </div>
  </div>
</div>
@endsection