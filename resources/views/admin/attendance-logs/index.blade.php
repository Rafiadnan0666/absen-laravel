@extends('admin.dashboard.layout')

@section('title', 'Attendance Logs - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">Attendance Logs</h6>
    </div>
    @if(session('success'))
      <div class="neo-alert-success mb-4">
        {{ session('success') }}
      </div>
    @endif
    <div class="neo-table-container overflow-x-auto">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Type</th>
            <th>Time</th>
            <th>Location</th>
            <th>Device</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($attendanceLogs as $log)
          <tr>
            <td class="font-bold">{{ $log->id }}</td>
            <td class="font-bold">{{ $log->user->name ?? 'N/A' }}</td>
            <td>
              {{ ucfirst(str_replace('_', ' ', $log->tipe_log)) }}
            </td>
            <td class="text-sm">{{ $log->waktu_log->format('d M Y H:i') }}</td>
            <td class="text-sm">
              @if($log->latitude && $log->longitude)
                {{ $log->latitude }}, {{ $log->longitude }}
              @else
                N/A
              @endif
            </td>
            <td class="text-sm">{{ $log->device ?? 'N/A' }}</td>
            <td class="text-center">
              <a href="{{ route('admin.attendance-logs.show', $log) }}" class="neo-btn-secondary text-sm">View</a>
              <form action="{{ route('admin.attendance-logs.destroy', $log) }}" method="POST" class="inline" onsubmit="return confirm('Delete this log?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger text-sm">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center p-4">No attendance logs found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="p-4">
        {{ $attendanceLogs->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
