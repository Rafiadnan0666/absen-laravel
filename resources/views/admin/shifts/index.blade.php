@extends('admin.dashboard.layout')

@section('title', 'Shifts - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
      <h6 class="neo-section-title">SHIFTS</h6>
      <a href="{{ route('admin.shifts.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Shift
      </a>
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
            <th class="text-left p-3 border-b-3 border-black font-bold uppercase text-sm">ID</th>
            <th class="text-left p-3 border-b-3 border-black font-bold uppercase text-sm">Name</th>
            <th class="text-left p-3 border-b-3 border-black font-bold uppercase text-sm">Start Time</th>
            <th class="text-left p-3 border-b-3 border-black font-bold uppercase text-sm">End Time</th>
            <th class="text-center p-3 border-b-3 border-black font-bold uppercase text-sm">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($shifts as $shift)
          <tr class="border-b-2 border-black">
            <td class="p-3">{{ $shift->id }}</td>
            <td class="p-3 font-bold">{{ $shift->nama_shift }}</td>
            <td class="p-3">{{ $shift->jam_masuk }}</td>
            <td class="p-3">{{ $shift->jam_pulang }}</td>
            <td class="p-3 text-center">
              <a href="{{ route('admin.shifts.show', $shift) }}" class="neo-btn-secondary neo-btn-sm">View</a>
              <a href="{{ route('admin.shifts.edit', $shift) }}" class="neo-btn-secondary neo-btn-sm">Edit</a>
              <form action="{{ route('admin.shifts.destroy', $shift) }}" method="POST" class="inline" onsubmit="return confirm('Delete this shift?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger neo-btn-sm">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="p-4 text-center">No shifts found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $shifts->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection