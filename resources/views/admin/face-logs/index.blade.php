@extends('admin.dashboard.layout')

@section('title', 'Face Logs - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Face Logs</h6>
      </div>
      <div class="flex-auto p-6 px-0 pt-0 pb-2">
        @if(session('success'))
          <div class="p-4 mb-4 mx-6 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            {{ session('success') }}
          </div>
        @endif
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">ID</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">User</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Photo</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Confidence</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Match</th>
                <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Actions</th>
              </tr>
            </thead>
            <tbody>
              @forelse($faceLogs as $log)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $log->id }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $log->user->name ?? 'N/A' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  @if($log->foto_path)
                    <img src="{{ asset('storage/' . $log->foto_path) }}" alt="Face" class="h-10 w-10 rounded-lg object-cover">
                  @else
                    <p class="text-xs text-slate-400">No photo</p>
                  @endif
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs">{{ $log->confidence_score }}%</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  @if($log->is_match)
                    <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">Yes</span>
                  @else
                    <span class="bg-gradient-to-tl from-red-600 to-rose-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">No</span>
                  @endif
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent text-center">
                  <a href="{{ route('admin.face-logs.show', $log) }}" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-slate-600 to-slate-300 text-white rounded-2xl">View</a>
                  <form action="{{ route('admin.face-logs.destroy', $log) }}" method="POST" class="inline" onsubmit="return confirm('Delete this log?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-xs font-semibold inline-block px-2 py-1 mb-0 text-center uppercase align-middle leading-normal cursor-pointer bg-gradient-to-tl from-red-600 to-rose-400 text-white rounded-2xl">Delete</button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="p-4 text-center text-slate-400">No face logs found</td>
              </tr>
              @endforelse
            </tbody>
          </table>
          <div class="p-4">
            {{ $faceLogs->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
