@extends('admin.dashboard.layout')

@section('title', 'View Reimbursement - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">REIMBURSEMENT DETAILS</h6>
        <a href="{{ route('admin.reimbursements.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> BACK
        </a>
      </div>
    </div>

    <div class="mb-4">
      <label class="neo-label">ID</label>
      <p class="text-sm font-bold">{{ $reimbursement->id }}</p>
    </div>

    <div class="mb-4">
      <label class="neo-label">EMPLOYEE</label>
      <p class="text-sm">{{ $reimbursement->user->nama_lengkap ?? 'N/A' }} ({{ $reimbursement->user->email ?? 'N/A' }})</p>
    </div>

    <div class="mb-4">
      <label class="neo-label">AMOUNT</label>
      <p class="text-sm font-bold">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</p>
    </div>

    <div class="mb-4">
      <label class="neo-label">DESCRIPTION</label>
      <p class="text-sm whitespace-pre-wrap">{{ $reimbursement->deskripsi }}</p>
    </div>

    <div class="mb-4">
      <label class="neo-label">STATUS</label>
      @if($reimbursement->status == 'approved')
        <span class="neo-badge neo-badge-green">APPROVED</span>
      @elseif($reimbursement->status == 'pending')
        <span class="neo-badge neo-badge-yellow">PENDING</span>
      @else
        <span class="neo-badge neo-badge-red">REJECTED</span>
      @endif
    </div>

    <div class="mb-4">
      <label class="neo-label">APPROVED BY</label>
      <p class="text-sm">{{ $reimbursement->approvedBy->nama_lengkap ?? 'N/A' }}</p>
    </div>

    <div class="flex justify-end mt-6 space-x-2">
      <a href="{{ route('admin.reimbursements.edit', $reimbursement) }}" class="neo-btn-primary">
        <i class="fas fa-edit mr-1"></i> EDIT
      </a>
      @if($reimbursement->status == 'pending')
        <form action="{{ route('admin.reimbursements.approve', $reimbursement) }}" method="POST" class="inline">
          @csrf
          <button type="submit" class="neo-btn-primary">
            <i class="fas fa-check mr-1"></i> APPROVE
          </button>
        </form>
        <form action="{{ route('admin.reimbursements.reject', $reimbursement) }}" method="POST" class="inline">
          @csrf
          <button type="submit" class="neo-btn-danger">
            <i class="fas fa-times mr-1"></i> REJECT
          </button>
        </form>
      @endif
      <form action="{{ route('admin.reimbursements.destroy', $reimbursement) }}" method="POST" class="inline" onsubmit="return confirm('Delete this reimbursement?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="neo-btn-danger">
          <i class="fas fa-trash mr-1"></i> DELETE
        </button>
      </form>
    </div>
  </div>
</div>
@endsection