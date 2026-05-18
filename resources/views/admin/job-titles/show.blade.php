@extends('admin.dashboard.layout')

@section('title', 'View Job Title - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Job Title Details</h6>
          <div class="flex gap-2">
            <a href="{{ route('admin.job-titles.edit', $jobTitle) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white">
              Edit
            </a>
            <a href="{{ route('admin.job-titles.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
              Back
            </a>
          </div>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">ID</label>
          <p class="text-sm font-semibold text-slate-700">{{ $jobTitle->id }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Job Title Name</label>
          <p class="text-sm font-semibold text-slate-700">{{ $jobTitle->nama_jabatan }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Description</label>
          <p class="text-sm text-slate-700">{{ $jobTitle->deskripsi ?? '-' }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Default Salary</label>
          <p class="text-sm text-slate-700">Rp {{ number_format($jobTitle->default_gaji, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Created At</label>
          <p class="text-sm text-slate-700">{{ $jobTitle->created_at->format('d M Y H:i') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700">Employees ({{ $users->total() }})</label>
          <div class="overflow-x-auto mt-2">
            <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
              <thead>
                <tr>
                  <th class="px-4 py-2 text-left text-xxs font-bold uppercase">Name</th>
                  <th class="px-4 py-2 text-left text-xxs font-bold uppercase">Email</th>
                </tr>
              </thead>
              <tbody>
                @foreach($users as $user)
                <tr>
                  <td class="p-2 text-sm">{{ $user->nama_lengkap }}</td>
                  <td class="p-2 text-sm">{{ $user->email }}</td>
                </tr>
                @endforeach
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
