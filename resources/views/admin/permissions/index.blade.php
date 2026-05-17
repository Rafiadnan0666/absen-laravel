@extends('admin.dashboard.layout')

@section('title', 'Permissions - Admin')

@section('content')
<div class="space-y-6">
  <div>
    <div class="neo-card">
      <div class="mb-6 border-b-3 border-black pb-4">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Permissions</h6>
          <a href="{{ route('admin.permissions.create') }}" class="neo-btn-primary">
            <i class="fas fa-plus mr-1"></i> Add Permission
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
              <th class="text-left">Permission Name</th>
              <th class="text-left">Roles</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
          <tbody>
            @forelse($permissions as $permission)
            <tr>
              <td>{{ $permission->id }}</td>
              <td>{{ $permission->nama_permission }}</td>
              <td>
                <span class="neo-badge">{{ $permission->roles_count }}</span>
              </td>
              <td class="text-center">
                <a href="{{ route('admin.permissions.show', $permission) }}" class="neo-btn-secondary">View</a>
                <a href="{{ route('admin.permissions.edit', $permission) }}" class="neo-btn-secondary">Edit</a>
                <form action="{{ route('admin.permissions.destroy', $permission) }}" method="POST" class="inline" onsubmit="return confirm('Delete this permission?')">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="neo-btn-danger">Delete</button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="4" class="text-center p-4">No permissions found</td>
            </tr>
            @endforelse
          </tbody>
        </table>
        <div class="mt-4">
          {{ $permissions->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection