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
        @if($payroll->isPaid())
          <span class="neo-badge neo-badge-green">PAID</span>
        @elseif($payroll->isConfirmed())
          <span class="neo-badge neo-badge-cyan">CONFIRMED</span>
        @else
          <span class="neo-badge neo-badge-yellow">PENDING</span>
        @endif
      </div>
      <div class="mb-4">
        <label class="neo-label">Confirmed By</label>
        <p>{{ $payroll->confirmedBy->nama_lengkap ?? '-' }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Confirmed At</label>
        <p>{{ $payroll->confirmed_at?->format('d M Y H:i') ?? '-' }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Paid At</label>
        <p>{{ $payroll->paid_at?->format('d M Y H:i') ?? '-' }}</p>
      </div>
      @if($payroll->rejection_reason)
      <div class="mb-4">
        <label class="neo-label">Rejection Reason</label>
        <p class="text-neo-red">{{ $payroll->rejection_reason }}</p>
      </div>
      @endif
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

    @if(session('success'))
      <div class="neo-alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="neo-alert-danger mb-4">
        <ul class="list-disc pl-4">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    @if($payroll->auditLogs->count() > 0)
    <div class="mt-6 border-t-3 border-black pt-6">
      <label class="neo-label">Audit Trail</label>
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>Time</th>
            <th>Actor</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          @foreach($payroll->auditLogs as $log)
          <tr>
            <td>{{ $log->created_at->format('d M Y H:i') }}</td>
            <td>{{ $log->user->nama_lengkap ?? 'System' }}</td>
            <td><span class="neo-badge neo-badge-cyan">{{ $log->action }}</span></td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @endif

    <div class="flex flex-wrap justify-end gap-2 mt-6">
      @if($payroll->canBeConfirmed())
        <form action="{{ route('admin.payrolls.confirm', $payroll) }}" method="POST">
          @csrf
          <button type="submit" class="neo-btn-primary">
            <i class="fas fa-check mr-1"></i> Confirm Payroll
          </button>
        </form>
      @endif

      @if($payroll->canBePaid())
        <form action="{{ route('admin.payrolls.markPaid', $payroll) }}" method="POST">
          @csrf
          <button type="submit" class="neo-btn-primary">
            <i class="fas fa-money-bill-wave mr-1"></i> Mark as Paid
          </button>
        </form>
      @endif

      @if(! $payroll->isPaid())
        <a href="{{ route('admin.payrolls.edit', $payroll) }}" class="neo-btn-cyan">
          <i class="fas fa-edit mr-1"></i> Edit
        </a>
      @endif

      <form action="{{ route('admin.payrolls.destroy', $payroll) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="neo-btn-danger">
          <i class="fas fa-trash mr-1"></i> Delete
        </button>
      </form>
    </div>

    @if($payroll->canBeConfirmed())
    <form action="{{ route('admin.payrolls.reject', $payroll) }}" method="POST" class="mt-4 neo-card-yellow p-4">
      @csrf
      <label class="neo-label" for="rejection_reason">Reject Confirmation</label>
      <textarea id="rejection_reason" name="rejection_reason" rows="2" required class="neo-input" placeholder="Explain why this payroll cannot be confirmed"></textarea>
      <button type="submit" class="neo-btn-danger mt-2">Reject</button>
    </form>
    @endif
  </div>
</div>
@endsection