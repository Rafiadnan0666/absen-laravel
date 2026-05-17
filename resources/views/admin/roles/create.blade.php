@extends('admin.dashboard.layout')

@section('title', 'Create Role - Admin')

@section('content')
<h1 class="neo-section-title">CREATE ROLE</h1>

<div class="neo-card">
    <form action="{{ route('admin.roles.store') }}" method="POST">
        @csrf
        <div class="neo-form-group">
            <label for="nama_role" class="neo-label">ROLE NAME</label>
            <input type="text" id="nama_role" name="nama_role" value="{{ old('nama_role') }}" required class="neo-input" placeholder="Enter role name">
            @error('nama_role')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="neo-form-group">
            <label class="neo-label">PERMISSIONS</label>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 mt-2 p-4 border-3 border-black">
                @foreach($permissions as $permission)
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="permissions[]" value="{{ $permission->id }}" class="neo-checkbox" {{ in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                    <span class="font-bold text-sm">{{ $permission->nama_permission }}</span>
                </label>
                @endforeach
            </div>
            @error('permissions')
                <x-input-error :messages="$message" class="mt-2" />
            @enderror
        </div>

        <div class="flex gap-4 mt-6">
            <button type="submit" class="neo-btn-primary">
                SAVE
            </button>
            <a href="{{ route('admin.roles.index') }}" class="neo-btn-secondary">
                CANCEL
            </a>
        </div>
    </form>
</div>
@endsection