@extends('admin.dashboard.layout')

@section('title', 'View Face Log - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Face Log Details</h6>
          <a href="{{ route('admin.face-logs.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">ID</label>
          <p class="text-sm text-slate-500">{{ $faceLog->id }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">User</label>
          <p class="text-sm text-slate-500">{{ $faceLog->user->name ?? 'N/A' }} ({{ $faceLog->user->email ?? 'N/A' }})</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Photo</label>
          @if($faceLog->foto_path)
            <img src="{{ asset('storage/' . $faceLog->foto_path) }}" alt="Face Photo" class="max-w-sm rounded-lg shadow-soft-xl">
          @else
            <p class="text-sm text-slate-500">No photo available</p>
          @endif
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Confidence Score</label>
          <p class="text-sm text-slate-500">{{ $faceLog->confidence_score }}%</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Is Match</label>
          @if($faceLog->is_match)
            <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">Yes</span>
          @else
            <span class="bg-gradient-to-tl from-red-600 to-rose-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">No</span>
          @endif
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Created At</label>
          <p class="text-sm text-slate-500">{{ $faceLog->created_at->format('d M Y H:i:s') }}</p>
        </div>
        <div class="flex justify-end mt-6">
          <form action="{{ route('admin.face-logs.destroy', $faceLog) }}" method="POST" class="inline" onsubmit="return confirm('Delete this face log?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 text-white">
              <i class="fas fa-trash mr-1"></i> Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
