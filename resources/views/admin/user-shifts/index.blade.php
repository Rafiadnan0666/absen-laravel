@extends('admin.dashboard.layout')

@section('title', 'User Shifts - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">USER SHIFTS</h6>
      <a href="{{ route('admin.user-shifts.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> ADD USER SHIFT
      </a>
    </div>
    @if(session('success'))
      <div class="neo-alert-success mb-4">{{ session('success') }}</div>
    @endif
    <div class="neo-table-container overflow-x-auto">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>USER</th>
            <th>SHIFT</th>
            <th>DATE</th>
            <th>ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @forelse($userShifts as $userShift)
          <tr>
            <td>{{ $userShift->id }}</td>
            <td>{{ $userShift->user->nama_lengkap ?? 'N/A' }}</td>
            <td><span class="neo-badge">{{ $userShift->shift->nama_shift ?? 'N/A' }}</span></td>
            <td>{{ $userShift->tanggal_shift->format('d M Y') }}</td>
            <td>
              <a href="{{ route('admin.user-shifts.show', $userShift) }}" class="neo-btn-secondary neo-btn-sm">VIEW</a>
              <a href="{{ route('admin.user-shifts.edit', $userShift) }}" class="neo-btn-secondary neo-btn-sm">EDIT</a>
              <form action="{{ route('admin.user-shifts.destroy', $userShift) }}" method="POST" class="inline" onsubmit="return confirm('Delete this user shift?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger neo-btn-sm">DELETE</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">No user shifts found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
    <div class="mt-4">
      {{ $userShifts->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection