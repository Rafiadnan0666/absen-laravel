@extends('admin.dashboard.layout')

@section('title', 'Employees - Admin')

@section('content')
<h1 class="neo-section-title">EMPLOYEES</h1>

@if(session('success'))
    <div class="neo-alert-success mb-6">{{ session('success') }}</div>
@endif

<div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h2 class="neo-section-title">ALL EMPLOYEES</h2>
        <a href="{{ route('admin.users.create') }}" class="neo-btn-primary neo-btn-sm">ADD EMPLOYEE</a>
    </div>

    <div class="neo-table-container">
        <table class="neo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Department</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td class="font-black">{{ $user->id }}</td>
                    <td class="font-bold">{{ $user->nama_lengkap }}</td>
                    <td>{{ $user->email }}</td>
                    <td class="font-bold">{{ $user->department->nama_department ?? 'N/A' }}</td>
                    <td><span class="neo-badge neo-badge-purple">{{ $user->role->nama_role ?? 'N/A' }}</span></td>
                    <td>
                        @if($user->status_akun == 'active')
                            <span class="neo-badge neo-badge-green">ACTIVE</span>
                        @else
                            <span class="neo-badge neo-badge-red">INACTIVE</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.users.show', $user) }}" class="neo-btn-secondary neo-btn-sm">VIEW</a>
                        <a href="{{ route('admin.users.edit', $user) }}" class="neo-btn-cyan neo-btn-sm">EDIT</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="neo-btn-danger neo-btn-sm" onclick="return confirm('Delete?')">DELETE</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-8 font-bold">No employees found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>
</div>
@endsection