@extends('admin.dashboard.layout')

@section('title', 'Audit Trail - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="text-xl font-bold uppercase tracking-wider">Audit Trail</h6>
    </div>

    <form method="GET" action="{{ route('admin.audit-logs.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-3 mb-6">
      <div>
        <label class="neo-label" for="action">Action</label>
        <select id="action" name="action" class="neo-input">
          <option value="">All actions</option>
          @foreach(['leave', 'reimbursement', 'payroll'] as $prefix)
            <option value="{{ $prefix }}" {{ request('action') === $prefix ? 'selected' : '' }}>{{ ucfirst($prefix) }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="neo-label" for="user_id">Actor</label>
        <select id="user_id" name="user_id" class="neo-input">
          <option value="">All users</option>
          @foreach($users as $user)
            <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>{{ $user->nama_lengkap }}</option>
          @endforeach
        </select>
      </div>
      <div>
        <label class="neo-label" for="date_from">From</label>
        <input type="date" id="date_from" name="date_from" value="{{ request('date_from') }}" class="neo-input">
      </div>
      <div>
        <label class="neo-label" for="date_to">To</label>
        <div class="flex gap-2">
          <input type="date" id="date_to" name="date_to" value="{{ request('date_to') }}" class="neo-input">
          <button type="submit" class="neo-btn-primary">Filter</button>
        </div>
      </div>
    </form>

    <div class="overflow-x-auto">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>Time</th>
            <th>Actor</th>
            <th>Action</th>
            <th>Subject</th>
            <th>Changes</th>
            <th>IP</th>
          </tr>
        </thead>
        <tbody>
          @forelse($logs as $log)
          <tr>
            <td class="whitespace-nowrap">{{ $log->created_at->format('d M Y H:i') }}</td>
            <td>{{ $log->user->nama_lengkap ?? 'System' }}</td>
            <td><span class="neo-badge neo-badge-cyan">{{ $log->action }}</span></td>
            <td>{{ class_basename($log->auditable_type) }} #{{ $log->auditable_id }}</td>
            <td class="text-xs">
              @if($log->new_values)
                <code>{{ \Illuminate\Support\Str::limit(json_encode($log->new_values), 120) }}</code>
              @else
                -
              @endif
            </td>
            <td>{{ $log->ip_address ?? '-' }}</td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center p-4">No audit entries found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="mt-4">
        {{ $logs->links('vendor.pagination.neo') }}
      </div>
    </div>
  </div>
</div>
@endsection
