@extends('admin.dashboard.layout')

@section('title', 'Reimbursements - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 pb-4 border-b-3 border-black">
      <h6 class="text-xl font-bold">REIMBURSEMENTS</h6>
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
            <th class="neo-label">EMPLOYEE</th>
            <th class="neo-label">AMOUNT</th>
            <th class="neo-label">CATEGORY</th>
            <th class="neo-label">STATUS</th>
            <th class="neo-label text-center">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reimbursements as $reimbursement)
          <tr>
            <td class="border-b-3 border-black py-3">{{ $reimbursement->user->nama_lengkap ?? 'N/A' }}</td>
            <td class="border-b-3 border-black py-3">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</td>
            <td class="border-b-3 border-black py-3">{{ $reimbursement->kategori ?? 'N/A' }}</td>
            <td class="border-b-3 border-black py-3">
              @if($reimbursement->status == 'approved')
                <span class="neo-badge neo-badge-green">APPROVED</span>
              @elseif($reimbursement->status == 'pending')
                <span class="neo-badge neo-badge-yellow">PENDING</span>
              @else
                <span class="neo-badge neo-badge-red">REJECTED</span>
              @endif
            </td>
            <td class="border-b-3 border-black py-3 text-center space-x-2">
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
            <td colspan="5" class="py-8 text-center">No reimbursement requests found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $reimbursements->links() }}
    </div>
  </div>
</div>
@endsection