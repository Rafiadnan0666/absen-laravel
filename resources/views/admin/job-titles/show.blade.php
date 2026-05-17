@extends('admin.dashboard.layout')

@section('title', 'View Job Title - Admin')

@section('content')
<div class="space-y-6">
  <div>
    <div class="neo-card">
      <div class="mb-4 border-b-3 border-black pb-4">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Job Title Details</h6>
          <div class="flex gap-2">
            <a href="{{ route('admin.job-titles.edit', $jobTitle) }}" class="neo-btn-secondary">
              Edit
            </a>
            <a href="{{ route('admin.job-titles.index') }}" class="neo-btn-secondary">
              Back
            </a>
          </div>
        </div>
      </div>
      <div>
        <div class="mb-4">
          <label class="neo-label">ID</label>
          <p class="text-sm font-bold">{{ $jobTitle->id }}</p>
        </div>
        <div class="mb-4">
          <label class="neo-label">Job Title Name</label>
          <p class="text-sm font-bold">{{ $jobTitle->nama_jabatan }}</p>
        </div>
        <div class="mb-4">
          <label class="neo-label">Description</label>
          <p class="text-sm">{{ $jobTitle->deskripsi ?? '-' }}</p>
        </div>
        <div class="mb-4">
          <label class="neo-label">Default Salary</label>
          <p class="text-sm">Rp {{ number_format($jobTitle->default_gaji, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <label class="neo-label">Created At</label>
          <p class="text-sm">{{ $jobTitle->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="mb-4">
          <label class="neo-label">Employees ({{ $jobTitle->users->count() }})</label>
          <div class="overflow-x-auto mt-2">
            <table class="neo-table w-full mb-0 align-top">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Email</th>
                </tr>
              </thead>
              <tbody>
                @foreach($jobTitle->users as $user)
                <tr>
                  <td>{{ $user->nama_lengkap }}</td>
                  <td>{{ $user->email }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection