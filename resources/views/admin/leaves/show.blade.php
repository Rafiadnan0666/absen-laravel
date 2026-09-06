@extends('admin.dashboard.layout')

@section('title', 'View Leave - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h2 class="text-xl font-bold uppercase tracking-wide">Leave Details</h2>
        <a href="{{ route('admin.leaves.index') }}" class="neo-btn-secondary">
          <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
      </div>
    </div>

    <div class="space-y-4">
      <div>
        <label class="neo-label">ID</label>
        <p class="text-sm font-bold">{{ $leave->id }}</p>
      </div>
      <div>
        <label class="neo-label">Employee</label>
        <p class="text-sm font-bold">{{ $leave->user->nama_lengkap ?? 'N/A' }} ({{ $leave->user->email ?? 'N/A' }})</p>
      </div>
      <div>
        <label class="neo-label">Leave Type</label>
        <span class="neo-badge">{{ ucfirst($leave->tipe_cuti) }}</span>
      </div>
      <div>
        <label class="neo-label">Start Date</label>
        <p class="text-sm font-bold">{{ $leave->tanggal_mulai->format('d M Y') }}</p>
      </div>
      <div>
        <label class="neo-label">End Date</label>
        <p class="text-sm font-bold">{{ $leave->tanggal_selesai->format('d M Y') }}</p>
      </div>
      <div>
        <label class="neo-label">Reason</label>
        <p class="text-sm font-bold whitespace-pre-wrap">{{ $leave->alasan }}</p>
      </div>
      <div>
        <label class="neo-label">Status</label>
        @if($leave->status_pengajuan == 'approved')
          <span class="neo-badge neo-badge-green">{{ strtoupper($leave->status_pengajuan) }}</span>
        @elseif($leave->status_pengajuan == 'pending')
          <span class="neo-badge neo-badge-yellow">{{ strtoupper($leave->status_pengajuan) }}</span>
        @else
          <span class="neo-badge neo-badge-red">{{ strtoupper($leave->status_pengajuan) }}</span>
        @endif
      </div>
      <div>
        <label class="neo-label">Approved By</label>
        <p class="text-sm font-bold">{{ $leave->approvedBy->nama_lengkap ?? 'N/A' }}</p>
      </div>
    </div>

    <div class="flex justify-end mt-6 space-x-2">
      <a href="{{ route('admin.leaves.edit', $leave) }}" class="neo-btn-primary">
        <i class="fas fa-edit mr-1"></i> Edit
      </a>
      @if($leave->status_pengajuan == 'pending')
        <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST" class="inline">
          @csrf
          <button type="submit" class="neo-btn-primary">
            <i class="fas fa-check mr-1"></i> Approve
          </button>
        </form>
        <form action="{{ route('admin.leaves.reject', $leave) }}" method="POST" class="inline">
          @csrf
          <button type="submit" class="neo-btn-danger">
            <i class="fas fa-times mr-1"></i> Reject
          </button>
        </form>
      @endif
      <form action="{{ route('admin.leaves.destroy', $leave) }}" method="POST" class="inline" onsubmit="return confirm('Delete this leave request?')">
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