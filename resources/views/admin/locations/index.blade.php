@extends('admin.dashboard.layout')

@section('title', 'Locations - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="border-b-3 border-black pb-4 mb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">LOCATIONS</h6>
        <a href="{{ route('admin.locations.create') }}" class="neo-btn-primary">
          <i class="fas fa-plus mr-1"></i> ADD LOCATION
        </a>
      </div>
    </div>

    @if(session('success'))
      <div class="neo-badge neo-badge-green mb-4">
        {{ session('success') }}
      </div>
    @endif

    <div class="neo-table-container">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th class="text-left">ID</th>
            <th class="text-left">NAME</th>
            <th class="text-left">COORDINATES</th>
            <th class="text-left">RADIUS</th>
            <th class="text-center">ACTIONS</th>
          </tr>
        </thead>
        <tbody>
          @forelse($locations as $location)
          <tr>
            <td>
              <span class="neo-label">{{ $location->id }}</span>
            </td>
            <td>
              <span class="font-bold">{{ $location->nama_lokasi }}</span>
            </td>
            <td>
              <span>{{ $location->latitude }}, {{ $location->longitude }}</span>
            </td>
            <td>
              <span class="neo-badge neo-badge-green">{{ $location->radius_meter }}m</span>
            </td>
            <td class="text-center">
              <a href="{{ route('admin.locations.show', $location) }}" class="neo-btn-secondary">VIEW</a>
              <a href="{{ route('admin.locations.edit', $location) }}" class="neo-btn-secondary">EDIT</a>
              <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="inline" onsubmit="return confirm('DELETE THIS LOCATION?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger">DELETE</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center p-4">NO LOCATIONS FOUND</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $locations->links() }}
    </div>
  </div>
</div>
@endsection