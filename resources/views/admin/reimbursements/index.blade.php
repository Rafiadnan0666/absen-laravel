@extends('admin.dashboard.layout')

@section('title', 'Reimbursements - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 pb-4 border-b-3 border-black">
      <h6 class="neo-section-title">REIMBURSEMENTS</h6>
      <a href="{{ route('admin.reimbursements.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> ADD REIMBURSEMENT
      </a>
    </div>

    @if(session('success'))
      <div class="neo-alert-success mb-4">
        {{ session('success') }}
      </div>
    @endif

    <div class="neo-table-container">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>EMPLOYEE</th>
            <th>AMOUNT</th>
            <th>CATEGORY</th>
            <th>STATUS</th>
            <th class="text-center">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reimbursements as $reimbursement)
          <tr>
            <td>{{ $reimbursement->user->nama_lengkap ?? 'N/A' }}</td>
            <td>Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</td>
            <td>{{ $reimbursement->kategori ?? 'N/A' }}</td>
            <td>
              @if($reimbursement->status == 'approved')
                <span class="neo-badge neo-badge-green">APPROVED</span>
              @elseif($reimbursement->status == 'pending')
                <span class="neo-badge neo-badge-yellow">PENDING</span>
              @else
                <span class="neo-badge neo-badge-red">REJECTED</span>
              @endif
            </td>
            <td class="text-center space-x-2">
              <a href="{{ route('admin.reimbursements.show', $reimbursement) }}" class="neo-btn-secondary">VIEW</a>
              <a href="{{ route('admin.reimbursements.edit', $reimbursement) }}" class="neo-btn-secondary">EDIT</a>
              @if($reimbursement->status == 'pending')
                <form action="{{ route('admin.reimbursements.approve', $reimbursement) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-primary">APPROVE</button>
                </form>
                <form action="{{ route('admin.reimbursements.reject', $reimbursement) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-danger">REJECT</button>
                </form>
              @endif
              <form action="{{ route('admin.reimbursements.destroy', $reimbursement) }}" method="POST" class="inline" onsubmit="return confirm('Delete this reimbursement?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger">DELETE</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center p-4">No reimbursement requests found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $reimbursements->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection