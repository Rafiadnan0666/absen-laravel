@extends('admin.dashboard.layout')

@section('title', 'View Role - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Role Details</h6>
          <div class="flex gap-2">
            <a href="{{ route('admin.roles.edit', $role) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white">
              Edit
            </a>
            <a href="{{ route('admin.roles.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
              Back
            </a>
          </div>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">ID</label>
          <p class="text-sm font-semibold text-slate-700">{{ $role->id }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Role Name</label>
          <p class="text-sm font-semibold text-slate-700">{{ $role->nama_role }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Created At</label>
          <p class="text-sm text-slate-700">{{ $role->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Permissions ({{ $role->permissions->count() }})</label>
          <div class="flex flex-wrap gap-2 mt-2">
            @forelse($role->permissions as $permission)
              <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-3 py-1 text-xs rounded-2xl text-white inline-block">{{ $permission->nama_permission }}</span>
            @empty
              <p class="text-sm text-slate-400">No permissions assigned</p>
            @endforelse
          </div>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Users ({{ $users->total() }})</label>
          <div class="overflow-x-auto mt-2">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
              <thead>
                <tr>
                  <th class="px-4 py-2 text-left text-xxs font-bold uppercase">Name</th>
                  <th class="px-4 py-2 text-left text-xxs font-bold uppercase">Email</th>
                </tr>
              </thead>
              <tbody>
                @forelse($users as $user)
                <tr>
                  <td class="p-2 text-sm">{{ $user->nama_lengkap }}</td>
                  <td class="p-2 text-sm">{{ $user->email }}</td>
                </tr>
                @empty
                <tr>
                  <td colspan="2" class="p-4 text-center text-slate-400">No users with this role</td>
                </tr>
                @endforelse
              </tbody>
            </table>
            <div class="mt-4">
              {{ $users->links() }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
