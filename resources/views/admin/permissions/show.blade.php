@extends('admin.dashboard.layout')

@section('title', 'View Permission - Admin')

@section('content')
<div class="space-y-6">
  <div>
    <div class="neo-card">
      <div class="mb-6 border-b-3 border-black pb-4">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Permission Details</h6>
          <div class="flex gap-2">
            <a href="{{ route('admin.permissions.edit', $permission) }}" class="neo-btn-secondary">Edit</a>
            <a href="{{ route('admin.permissions.index') }}" class="neo-btn-secondary">Back</a>
          </div>
        </div>
      </div>
      <div class="mb-4">
        <label class="neo-label">ID</label>
        <p class="font-bold">{{ $permission->id }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Permission Name</label>
        <p class="font-bold">{{ $permission->nama_permission }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Created At</label>
        <p>{{ $permission->created_at->format('d M Y H:i') }}</p>
      </div>
      <div class="mb-4">
        <label class="neo-label">Roles ({{ $permission->roles->count() }})</label>
        <div class="overflow-x-auto mt-2">
          <table class="neo-table w-full">
            <thead>
              <tr>
                <th class="text-left">Role Name</th>
              </tr>
            </thead>
            <tbody>
              @foreach($permission->roles as $role)
              <tr>
                <td>{{ $role->nama_role }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection