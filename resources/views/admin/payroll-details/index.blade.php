@extends('admin.dashboard.layout')

@section('title', 'Payroll Details - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card p-6">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">PAYROLL DETAILS</h6>
      <a href="{{ route('admin.payroll-details.create') }}" class="neo-btn-primary">+ ADD DETAIL</a>
    </div>

    @if(session('success'))
      <div class="neo-alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="overflow-x-auto">
      <table class="neo-table">
        <thead>
          <tr>
            <th>ID</th>
            <th>EMPLOYEE</th>
            <th>TYPE</th>
            <th>AMOUNT</th>
            <th>DESCRIPTION</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @forelse($payrollDetails as $detail)
          <tr>
            <td class="font-bold">{{ $detail->id }}</td>
            <td>{{ $detail->payroll->user->nama_lengkap ?? 'N/A' }}</td>
            <td><span class="neo-badge">{{ ucfirst($detail->tipe) }}</span></td>
            <td>Rp {{ number_format($detail->jumlah, 2, ',', '.') }}</td>
            <td>{{ $detail->deskripsi ?? '-' }}</td>
            <td>
              <a href="{{ route('admin.payroll-details.show', $detail) }}" class="neo-btn-secondary neo-btn-sm">VIEW</a>
              <a href="{{ route('admin.payroll-details.edit', $detail) }}" class="neo-btn-secondary neo-btn-sm">EDIT</a>
              <form action="{{ route('admin.payroll-details.destroy', $detail) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll detail?')">
                @csrf @method('DELETE')
                <button type="submit" class="neo-btn-danger neo-btn-sm">DELETE</button>
              </form>
            </td>
          </tr>
          @empty
          <tr><td colspan="6" class="text-center py-6">No payroll details found.</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-4">{{ $payrollDetails->links('vendor.pagination.neo') }}</div>
  </div>
</div>
@endsection
