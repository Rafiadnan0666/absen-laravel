@extends('admin.dashboard.layout')

@section('title', 'Leave Requests - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6">
      <h2 class="text-2xl font-bold uppercase tracking-wide">Leave Requests</h2>
      <a href="{{ route('admin.leaves.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Leave
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
            <th class="text-left uppercase tracking-wide">Employee</th>
            <th class="text-left uppercase tracking-wide">Type</th>
            <th class="text-left uppercase tracking-wide">Start Date</th>
            <th class="text-left uppercase tracking-wide">End Date</th>
            <th class="text-left uppercase tracking-wide">Status</th>
            <th class="text-center uppercase tracking-wide">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($leaves as $leave)
          <tr>
            <td class="font-bold">{{ $leave->user->nama_lengkap ?? 'N/A' }}</td>
            <td><span class="neo-label">{{ ucfirst($leave->tipe_cuti) }}</span></td>
            <td>{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
            <td>
              @if($leave->status_pengajuan == 'approved')
                <span class="neo-badge neo-badge-green">Approved</span>
              @elseif($leave->status_pengajuan == 'pending')
                <span class="neo-badge neo-badge-yellow">Pending</span>
              @else
                <span class="neo-badge neo-badge-red">Rejected</span>
              @endif
            </td>
            <td class="text-center">
              <a href="{{ route('admin.leaves.show', $leave) }}" class="neo-btn-secondary text-sm">View</a>
              <a href="{{ route('admin.leaves.edit', $leave) }}" class="neo-btn-primary text-sm">Edit</a>
              @if($leave->status_pengajuan == 'pending')
                <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-primary text-sm">Approve</button>
                </form>
                <form action="{{ route('admin.leaves.reject', $leave) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-danger text-sm">Reject</button>
                </form>
              @endif
              <form action="{{ route('admin.leaves.destroy', $leave) }}" method="POST" class="inline" onsubmit="return confirm('Delete this leave?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger text-sm">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center p-4">No leave requests found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $leaves->links() }}
    </div>
  </div>
</div>
@endsection