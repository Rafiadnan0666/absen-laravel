@extends('admin.dashboard.layout')

@section('title', 'View Salary Rule - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Salary Rule Details</h6>
          <a href="{{ route('admin.salary-rules.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">ID</label>
          <p class="text-sm text-slate-500">{{ $salaryRule->id }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Type</label>
          <span class="bg-gradient-to-tl from-blue-600 to-cyan-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">{{ ucfirst($salaryRule->tipe_gaji) }}</span>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Overtime Rate</label>
          <p class="text-sm text-slate-500">{{ $salaryRule->rate_lembur }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Late Penalty per Minute</label>
          <p class="text-sm text-slate-500">{{ $salaryRule->penalti_telat_per_menit }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Absent Penalty</label>
          <p class="text-sm text-slate-500">{{ $salaryRule->penalti_tidak_hadir }}</p>
        </div>
        <div class="flex justify-end mt-6">
          <a href="{{ route('admin.salary-rules.edit', $salaryRule) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-2">
            <i class="fas fa-edit mr-1"></i> Edit
          </a>
          <form action="{{ route('admin.salary-rules.destroy', $salaryRule) }}" method="POST" class="inline" onsubmit="return confirm('Delete this salary rule?')">
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
