@extends('admin.dashboard.layout')

@section('title', 'Edit Role - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Edit Role</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.roles.update', $role) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="nama_role" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Role Name</label>
            <input type="text" id="nama_role" name="nama_role" value="{{ old('nama_role', $role->nama_role) }}" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding py-2 px-3 font-normal text-gray-700 transition-all focus:border-fuchsia-300 focus:bg-white focus:text-gray-700 focus:outline-none focus:transition-shadow" />
            @error('nama_role')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Permissions</label>
            @php
              $rolePermissionIds = $role->permissions->pluck('id')->toArray();
            @endphp
            <div class="grid grid-cols-2 md:grid-cols-3 gap-2 mt-2">
              @foreach($permissions as $permission)
              <label class="inline-flex items-center">
                <input type="checkbox" name="permissions[]" value="{{ $permission->id }}"
                  class="form-checkbox rounded text-blue-600 focus:ring-blue-500"
                  {{ in_array($permission->id, old('permissions', $rolePermissionIds)) ? 'checked' : '' }} />
                <span class="ml-2 text-sm text-slate-700">{{ $permission->nama_permission }}</span>
              </label>
              @endforeach
            </div>
            @error('permissions')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
            @error('permissions.*')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex gap-4">
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
              Update
            </button>
            <a href="{{ route('admin.roles.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
              Cancel
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
