@extends('admin.dashboard.layout')

@section('title', 'Face Logs - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-4 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold">Face Logs</h6>
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
            <th>Photo</th>
            <th>Confidence</th>
            <th>Match</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($faceLogs as $log)
          <tr>
            <td class="font-bold">{{ $log->id }}</td>
            <td class="font-bold">{{ $log->user->name ?? 'N/A' }}</td>
            <td>
              @if($log->foto_path)
                <img src="{{ asset('storage/' . $log->foto_path) }}" alt="Face" class="h-10 w-10 object-cover">
              @else
                <p class="text-sm">No photo</p>
              @endif
            </td>
            <td class="text-sm">{{ $log->confidence_score }}%</td>
            <td>
              @if($log->is_match)
                <span class="neo-badge neo-badge-green">Yes</span>
              @else
                <span class="neo-badge neo-badge-red">No</span>
              @endif
            </td>
            <td class="text-center">
              <a href="{{ route('admin.face-logs.show', $log) }}" class="neo-btn-secondary text-sm">View</a>
              <form action="{{ route('admin.face-logs.destroy', $log) }}" method="POST" class="inline" onsubmit="return confirm('Delete this log?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger text-sm">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center p-4">No face logs found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="p-4">
        {{ $faceLogs->links() }}
      </div>
    </div>
  </div>
</div>
@endsection
