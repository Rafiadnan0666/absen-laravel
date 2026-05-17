@extends('admin.dashboard.layout')

@section('title', 'View Department - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="mb-6 border-b-3 border-black pb-4">
      <div class="flex justify-between items-center">
        <h6 class="text-xl font-bold">Department Details</h6>
        <div class="flex gap-2">
          <a href="{{ route('admin.departments.edit', $department) }}" class="neo-btn-primary">
            Edit
          </a>
          <a href="{{ route('admin.departments.index') }}" class="neo-btn-secondary">
            Back
          </a>
        </div>
      </div>
    </div>
    <div class="space-y-4">
      <div>
        <label class="neo-label">ID</label>
        <p class="text-sm font-bold">{{ $department->id }}</p>
      </div>
      <div>
        <label class="neo-label">Department Name</label>
        <p class="text-sm font-bold">{{ $department->nama_department }}</p>
      </div>
      <div>
        <label class="neo-label">Description</label>
        <p class="text-sm">{{ $department->deskripsi ?? '-' }}</p>
      </div>
      <div>
        <label class="neo-label">Created At</label>
        <p class="text-sm">{{ $department->created_at->format('d M Y H:i') }}</p>
      </div>
      <div>
        <label class="neo-label">Employees ({{ $department->users->count() }})</label>
        <div class="neo-table-container mt-2">
          <table class="neo-table w-full">
            <thead>
              <tr>
                <th class="neo-label">Name</th>
                <th class="neo-label">Email</th>
              </tr>
            </thead>
            <tbody>
              @foreach($department->users as $user)
              <tr>
                <td class="p-2 text-sm">{{ $user->nama_lengkap }}</td>
                <td class="p-2 text-sm">{{ $user->email }}</td>
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