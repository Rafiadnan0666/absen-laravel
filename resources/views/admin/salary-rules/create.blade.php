@extends('admin.dashboard.layout')

@section('title', 'Create Salary Rule - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Create Salary Rule</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.salary-rules.store') }}" method="POST">
          @csrf
          <div class="mb-4">
            <label for="tipe_gaji" class="inline-block mb-2 text-sm font-bold text-slate-700">Salary Type</label>
            <select id="tipe_gaji" name="tipe_gaji" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Type</option>
              <option value="hourly" {{ old('tipe_gaji') == 'hourly' ? 'selected' : '' }}>Hourly</option>
              <option value="daily" {{ old('tipe_gaji') == 'daily' ? 'selected' : '' }}>Daily</option>
              <option value="monthly" {{ old('tipe_gaji') == 'monthly' ? 'selected' : '' }}>Monthly</option>
            </select>
            @error('tipe_gaji')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="rate_lembur" class="inline-block mb-2 text-sm font-bold text-slate-700">Overtime Rate</label>
            <input type="number" step="0.01" id="rate_lembur" name="rate_lembur" value="{{ old('rate_lembur') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter overtime rate" required>
            @error('rate_lembur')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="penalti_telat_per_menit" class="inline-block mb-2 text-sm font-bold text-slate-700">Late Penalty per Minute</label>
            <input type="number" step="0.01" id="penalti_telat_per_menit" name="penalti_telat_per_menit" value="{{ old('penalti_telat_per_menit') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter late penalty per minute" required>
            @error('penalti_telat_per_menit')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="penalti_tidak_hadir" class="inline-block mb-2 text-sm font-bold text-slate-700">Absent Penalty</label>
            <input type="number" step="0.01" id="penalti_tidak_hadir" name="penalti_tidak_hadir" value="{{ old('penalti_tidak_hadir') }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter absent penalty" required>
            @error('penalti_tidak_hadir')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-end">
            <a href="{{ route('admin.salary-rules.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white mr-2">
              Cancel
            </a>
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
              Create
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
