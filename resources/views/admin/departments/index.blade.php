@extends('admin.dashboard.layout')

@section('title', 'Departments - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="flex justify-between items-center mb-6">
      <h2 class="neo-section-title">DEPARTMENTS</h2>
      <a href="{{ route('admin.departments.create') }}" class="neo-btn-primary">
        <i class="fas fa-plus mr-1"></i> Add Department
      </a>
    </div>

    @if(session('success'))
      <div class="neo-alert-success mb-4">
        {{ session('success') }}
      </div>
    @endif

    <div class="neo-table-container">
      <table class="neo-table w-full">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Description</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($departments as $department)
          <tr>
            <td>
              <span>{{ $department->id }}</span>
            </td>
            <td>
              <span class="font-bold">{{ $department->nama_department }}</span>
            </td>
            <td>
              {{ Str::limit($department->deskripsi, 50) ?? '-' }}
            </td>
            <td class="text-center">
              <a href="{{ route('admin.departments.show', $department) }}" class="neo-btn-secondary inline-block">View</a>
              <a href="{{ route('admin.departments.edit', $department) }}" class="neo-btn-secondary inline-block">Edit</a>
              <form action="{{ route('admin.departments.destroy', $department) }}" method="POST" class="inline" onsubmit="return confirm('Delete this department?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="text-center p-4">No departments found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $departments->links('vendor.pagination.neo') }}
    </div>
  </div>
</div>
@endsection