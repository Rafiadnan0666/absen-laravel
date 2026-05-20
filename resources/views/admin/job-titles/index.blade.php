@extends('admin.dashboard.layout')

@section('title', 'Job Titles - Admin')

@section('content')
<div class="space-y-6">
  <div>
    <div class="neo-card">
      <div class="mb-4 border-b-3 border-black pb-4">
        <div class="flex justify-between items-center">
          <h6 class="neo-section-title">JOB TITLES</h6>
          <a href="{{ route('admin.job-titles.create') }}" class="neo-btn-primary">
            <i class="fas fa-plus mr-1"></i> Add Job Title
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
              <th>Name</th>
              <th>Default Salary</th>
              <th>Employees</th>
              <th class="text-center">Actions</th>
            </tr>
          </thead>
            <tbody>
              @forelse($jobTitles as $jobTitle)
              <tr>
                <td class="font-bold">{{ $jobTitle->id }}</td>
                <td class="font-bold">{{ $jobTitle->nama_jabatan }}</td>
                <td>Rp {{ number_format($jobTitle->default_gaji, 0, ',', '.') }}</td>
                <td>
                  <span class="neo-badge neo-badge-cyan">{{ $jobTitle->users_count }}</span>
                </td>
                <td class="text-center">
                  <a href="{{ route('admin.job-titles.show', $jobTitle) }}" class="neo-btn-secondary neo-btn-sm">View</a>
                  <a href="{{ route('admin.job-titles.edit', $jobTitle) }}" class="neo-btn-secondary neo-btn-sm">Edit</a>
                  <form action="{{ route('admin.job-titles.destroy', $jobTitle) }}" method="POST" class="inline" onsubmit="return confirm('Delete this job title?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="neo-btn-danger neo-btn-sm">Delete</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center">No job titles found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <div class="p-4">
            {{ $jobTitles->links('vendor.pagination.neo') }}
            </div>
      </div>
    </div>
  </div>
</div>
@endsection