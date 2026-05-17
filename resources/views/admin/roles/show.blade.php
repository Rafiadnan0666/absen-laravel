@extends('admin.dashboard.layout')

@section('title', 'View Role - Admin')

@section('content')
<h1 class="neo-section-title">ROLE DETAILS</h1>

<div class="neo-card">
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h2 class="font-black text-lg">{{ $role->nama_role }}</h2>
        <div class="flex gap-2">
            <a href="{{ route('admin.roles.edit', $role) }}" class="neo-btn-cyan neo-btn-sm">EDIT</a>
            <a href="{{ route('admin.roles.index') }}" class="neo-btn-secondary neo-btn-sm">BACK</a>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="p-4 border-3 border-black">
            <p class="text-sm font-bold uppercase ">ID</p>
            <p class="text-xl font-black">{{ $role->id }}</p>
        </div>
        <div class="p-4 border-3 border-black bg-neo-yellow">
            <p class="text-sm font-bold uppercase ">Role Name</p>
            <p class="text-xl font-black">{{ $role->nama_role }}</p>
        </div>
        <div class="p-4 border-3 border-black col-span-2">
            <p class="text-sm font-bold uppercase ">Created At</p>
            <p class="text-lg font-bold">{{ $role->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <div class="mb-6">
        <h3 class="neo-section-title">PERMISSIONS ({{ $role->permissions->count() }})</h3>
        <div class="flex flex-wrap gap-2 p-4 border-3 border-black bg-neo-cyan">
            @forelse($role->permissions as $permission)
                <span class="neo-badge neo-badge-green">{{ $permission->nama_permission }}</span>
            @empty
                <p class="font-bold">No permissions assigned</p>
            @endforelse
        </div>
    </div>

    <div>
        <h3 class="neo-section-title">USERS ({{ $role->users->count() }})</h3>
        <div class="neo-table-container">
            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($role->users as $user)
                    <tr>
                        <td class="font-bold">{{ $user->nama_lengkap }}</td>
                        <td>{{ $user->email }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="2" class="text-center py-4 font-bold">No users with this role</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection