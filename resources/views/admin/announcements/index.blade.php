@extends('admin.dashboard.layout')

@section('title', 'Announcements - Admin')

@section('content')
<div class="space-y-6">
  <div class="neo-card">
    <div class="border-b-3 border-black pb-4 mb-4">
      <div class="flex justify-between items-center">
        <h6 class="neo-section-title">ANNOUNCEMENTS</h6>
        <a href="{{ route('admin.announcements.create') }}" class="neo-btn-primary">
          <i class="fas fa-plus mr-1"></i> Add Announcement
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
            <th>ID</th>
            <th>Title</th>
            <th>Content</th>
            <th>Created By</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($announcements as $announcement)
          <tr>
            <td>{{ $announcement->id }}</td>
            <td>{{ $announcement->judul }}</td>
            <td>{{ Str::limit($announcement->isi, 50) }}</td>
            <td>{{ $announcement->creator->name ?? 'N/A' }}</td>
            <td class="text-center">
              <a href="{{ route('admin.announcements.show', $announcement) }}" class="neo-btn-secondary">View</a>
              <a href="{{ route('admin.announcements.edit', $announcement) }}" class="neo-btn-secondary">Edit</a>
              <form action="{{ route('admin.announcements.destroy', $announcement) }}" method="POST" class="inline" onsubmit="return confirm('Delete this announcement?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="neo-btn-danger">Delete</button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center p-4">No announcements found</td>
          </tr>
          @endforelse
        </tbody>
      </table>
      <div class="p-4">
        {{ $announcements->links('vendor.pagination.neo') }}
      </div>
    </div>
  </div>
</div>
@endsection