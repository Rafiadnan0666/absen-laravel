@extends('admin.dashboard.layout')

@section('title', 'Holidays - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="border-b-3 border-black pb-4 mb-4">
      <div class="flex justify-between items-center">
        <h6 class="neo-section-title">HOLIDAYS</h6>
        <a href="{{ route('admin.holidays.create') }}" class="neo-btn-primary">
          <i class="fas fa-plus mr-1"></i> Add Holiday
        </a>
      </div>
    </div>
    @if(session('success'))
      <div class="neo-alert-success mb-4">
        {{ session('success') }}
      </div>
    @endif
    <div class="overflow-x-auto">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th class="text-left">ID</th>
            <th class="text-left">Name</th>
            <th class="text-left">Date</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($holidays as $holiday)
          <tr>
            <td>{{ $holiday->id }}</td>
            <td>{{ $holiday->nama_hari_libur }}</td>
            <td>{{ $holiday->tanggal->format('d M Y') }}</td>
            <td class="text-center">
              <a href="{{ route('admin.holidays.show', $holiday) }}" class="neo-btn-secondary neo-btn-sm">View</a>
              <a href="{{ route('admin.holidays.edit', $holiday) }}" class="neo-btn-secondary neo-btn-sm">Edit</a>
              <form action="{{ route('admin.holidays.destroy', $holiday) }}" method="POST" class="inline" onsubmit="return confirm('Delete this holiday?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger neo-btn-sm">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center p-4">No holidays found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="p-4">
        {{ $holidays->links('vendor.pagination.neo') }}
      </div>
    </div>
  </div>
</div>
@endsection