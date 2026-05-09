@extends('admin.dashboard.layout')

@section('title', 'View Location - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Location Details</h6>
          <a href="{{ route('admin.locations.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Location Name</label>
          <p class="text-sm text-slate-500">{{ $location->nama_lokasi }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Latitude</label>
          <p class="text-sm text-slate-500">{{ $location->latitude }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Longitude</label>
          <p class="text-sm text-slate-500">{{ $location->longitude }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Radius (meters)</label>
          <p class="text-sm text-slate-500">{{ $location->radius_meter }} meters</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Attendance Count</label>
          <span class="bg-gradient-to-tl from-green-600 to-lime-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">{{ $location->attendances_count ?? $location->attendances()->count() }}</span>
        </div>
        <div class="flex justify-end mt-6">
          <a href="{{ route('admin.locations.edit', $location) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-2">
            <i class="fas fa-edit mr-1"></i> Edit
          </a>
          <form action="{{ route('admin.locations.destroy', $location) }}" method="POST" class="inline" onsubmit="return confirm('Delete this location?')">
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
