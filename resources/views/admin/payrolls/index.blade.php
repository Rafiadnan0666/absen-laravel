@extends('admin.dashboard.layout')

@section('title', 'Payroll Records - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">Payroll Records</h6>
      <a href="{{ route('admin.payrolls.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Payroll
      </a>
    </div>

    @if(session('success'))
      <div class="neo-alert-success mb-4" role="alert">
        {{ session('success') }}
      </div>
    @endif

    @if(session('error'))
      <div class="neo-alert-danger mb-4" role="alert">
        {{ session('error') }}
      </div>
    @endif

    @if($errors->any())
      <div class="neo-alert-danger mb-4" role="alert">
        <ul class="list-disc pl-4">
          @foreach($errors->all() as $err)
            <li>{{ $err }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="overflow-x-auto">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Employee</th>
            <th>Period</th>
            <th>Base Salary</th>
            <th>Overtime</th>
            <th>Deductions</th>
            <th>Total</th>
            <th>Status</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($payrolls as $payroll)
          <tr>
            <td class="font-bold">#{{ $payroll->id }}</td>
            <td>{{ $payroll->user->nama_lengkap ?? 'N/A' }}</td>
            <td>{{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('M Y') }}</td>
            <td>Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
            <td class="text-neo-green">+ Rp {{ number_format($payroll->total_lembur ?? 0, 0, ',', '.') }}</td>
            <td class="text-neo-red">- Rp {{ number_format($payroll->total_potongan ?? 0, 0, ',', '.') }}</td>
            <td class="font-bold">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</td>
            <td>
              @if($payroll->isPaid())
                <span class="neo-badge neo-badge-green">PAID</span>
              @elseif($payroll->isConfirmed())
                <span class="neo-badge neo-badge-cyan">CONFIRMED</span>
              @else
                <span class="neo-badge neo-badge-yellow">PENDING</span>
              @endif
            </td>
            <td class="text-center">
              <a href="{{ route('admin.payrolls.show', $payroll) }}" class="neo-btn-secondary text-sm">View</a>
              @if(! $payroll->isPaid())
                <a href="{{ route('admin.payrolls.edit', $payroll) }}" class="neo-btn-cyan text-sm">Edit</a>
              @endif
              @if($payroll->canBeConfirmed())
                <form action="{{ route('admin.payrolls.confirm', $payroll) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-primary text-sm">Confirm</button>
                </form>
              @endif
              @if($payroll->canBePaid())
                <form action="{{ route('admin.payrolls.markPaid', $payroll) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-primary text-sm">Mark Paid</button>
                </form>
              @endif
              <form action="{{ route('admin.payrolls.destroy', $payroll) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger text-sm">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="9" class="text-center p-4">No payroll records found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4">
        {{ $payrolls->links('vendor.pagination.neo') }}
      </div>
    </div>
  </div>
</div>
@endsection