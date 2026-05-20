@extends('admin.dashboard.layout')

@section('title', 'Leave Requests - Admin')

@section('content')
<div class="space-y-6">
  <div class="flex justify-between items-center mb-2 border-b-3 border-black pb-4 fade-in-up">
    <h2 class="text-2xl font-bold uppercase">LEAVE REQUESTS</h2>
    <a href="{{ route('admin.leaves.create') }}" class="neo-btn-primary neo-btn-sm pulse-glow">
      <i class="fas fa-plus mr-1"></i> Add Leave
    </a>
  </div>

  @if(session('success'))
    <div class="neo-alert-success mb-6 shake">{{ session('success') }}</div>
  @endif

  <x-advanced-filters :action="route('admin.leaves.index')" :filters="[
    'date_from' => ['type' => 'date', 'label' => 'Start From'],
    'date_to' => ['type' => 'date', 'label' => 'End To'],
    'status' => ['type' => 'select', 'label' => 'Status', 'options' => [
      'pending' => 'Pending',
      'approved' => 'Approved',
      'rejected' => 'Rejected',
    ]],
    'tipe_cuti' => ['type' => 'select', 'label' => 'Type', 'options' => [
      'sick' => 'Sick',
      'annual' => 'Annual',
      'unpaid' => 'Unpaid',
    ]],
    'user_id' => ['type' => 'select', 'label' => 'Employee', 'options' => $users->pluck('nama_lengkap', 'id')->toArray()],
  ]" />

  <div class="neo-card fade-in-up fade-in-up-d2">
    <div class="neo-table-container">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th class="text-left uppercase border-b-3 border-black">Employee</th>
            <th class="text-left uppercase border-b-3 border-black">Type</th>
            <th class="text-left uppercase border-b-3 border-black">Start Date</th>
            <th class="text-left uppercase border-b-3 border-black">End Date</th>
            <th class="text-left uppercase border-b-3 border-black">Status</th>
            <th class="text-center uppercase border-b-3 border-black">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($leaves as $leave)
          <tr class="hover-lift" style="transition: transform 0.2s, box-shadow 0.2s;">
            <td class="font-bold">{{ $leave->user->nama_lengkap ?? 'N/A' }}</td>
            <td><span class="neo-badge neo-badge-cyan">{{ ucfirst($leave->tipe_cuti) }}</span></td>
            <td>{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M Y') }}</td>
            <td>{{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
            <td>
              @if($leave->status_pengajuan == 'approved')
                <span class="neo-badge neo-badge-green status-pulse">APPROVED</span>
              @elseif($leave->status_pengajuan == 'pending')
                <span class="neo-badge neo-badge-yellow">PENDING</span>
              @else
                <span class="neo-badge neo-badge-red">REJECTED</span>
              @endif
            </td>
            <td class="text-center">
              <a href="{{ route('admin.leaves.show', $leave) }}" class="neo-btn-secondary neo-btn-sm">VIEW</a>
              <a href="{{ route('admin.leaves.edit', $leave) }}" class="neo-btn-primary neo-btn-sm">EDIT</a>
              @if($leave->status_pengajuan == 'pending')
                <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-green neo-btn-sm status-pulse">APPROVE</button>
                </form>
                <form action="{{ route('admin.leaves.reject', $leave) }}" method="POST" class="inline">
                  @csrf
                  <button type="submit" class="neo-btn-danger neo-btn-sm">REJECT</button>
                </form>
              @endif
              <form action="{{ route('admin.leaves.destroy', $leave) }}" method="POST" class="inline" onsubmit="return confirm('Delete this leave?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger neo-btn-sm">DELETE</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center p-8 font-bold">No leave requests found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $leaves->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection
