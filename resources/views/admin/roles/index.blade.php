@extends('admin.dashboard.layout')

@section('title', 'Roles - Admin')

@section('content')
<h1 class="neo-section-title">ROLES</h1>

@if(session('success'))
    <div class="neo-alert-success mb-6">
        {{ session('success') }}
    </div>
@endif

<div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h2 class="neo-section-title">ALL ROLES</h2>
        <a href="{{ route('admin.roles.create') }}" class="neo-btn-primary neo-btn-sm">
            ADD ROLE
        </a>
    </div>

    <div class="neo-table-container">
        <table class="neo-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Role Name</th>
                    <th>Users</th>
                    <th>Permissions</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td class="font-black">{{ $role->id }}</td>
                    <td class="font-bold">{{ $role->nama_role }}</td>
                    <td>
                        <span class="neo-badge neo-badge-green">{{ $role->users_count }}</span>
                    </td>
                    <td>
                        <span class="neo-badge neo-badge-cyan">{{ $role->permissions_count }}</span>
                    </td>
                    <td class="text-center">
                        <a href="{{ route('admin.roles.show', $role) }}" class="neo-btn-secondary neo-btn-sm">VIEW</a>
                        <a href="{{ route('admin.roles.edit', $role) }}" class="neo-btn-cyan neo-btn-sm">EDIT</a>
                        <form action="{{ route('admin.roles.destroy', $role) }}" method="POST" class="inline" onsubmit="return confirm('Delete this role?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="neo-btn-danger neo-btn-sm">DELETE</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-8 font-bold">No roles found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $roles->links('vendor.pagination.neo') }}
    </div>
</div>
@endsection