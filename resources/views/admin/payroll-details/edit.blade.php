@extends('admin.dashboard.layout')

@section('title', 'Edit Payroll Detail - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <h6 class="text-xl font-bold">Edit Payroll Detail</h6>
      </div>
      <div class="flex-auto p-6">
        <form action="{{ route('admin.payroll-details.update', $payrollDetail) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="mb-4">
            <label for="payroll_id" class="inline-block mb-2 text-sm font-bold text-slate-700">Payroll</label>
            <select id="payroll_id" name="payroll_id" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="">Select Payroll</option>
              @foreach($payrolls as $payroll)
                <option value="{{ $payroll->id }}" {{ $payrollDetail->payroll_id == $payroll->id ? 'selected' : '' }}>{{ $payroll->user->nama_lengkap }} - {{ $payroll->periode_mulai->format('M Y') }} ({{ $payroll->total_gaji }})</option>
              @endforeach
            </select>
            @error('payroll_id')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="tipe" class="inline-block mb-2 text-sm font-bold text-slate-700">Type</label>
            <select id="tipe" name="tipe" required
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none">
              <option value="base" {{ $payrollDetail->tipe == 'base' ? 'selected' : '' }}>Base Salary</option>
              <option value="overtime" {{ $payrollDetail->tipe == 'overtime' ? 'selected' : '' }}>Overtime</option>
              <option value="penalty" {{ $payrollDetail->tipe == 'penalty' ? 'selected' : '' }}>Penalty/Deduction</option>
              <option value="bonus" {{ $payrollDetail->tipe == 'bonus' ? 'selected' : '' }}>Bonus</option>
            </select>
            @error('tipe')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="jumlah" class="inline-block mb-2 text-sm font-bold text-slate-700">Amount</label>
            <input type="number" step="0.01" id="jumlah" name="jumlah" value="{{ $payrollDetail->jumlah }}"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter amount" required>
            @error('jumlah')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="mb-4">
            <label for="deskripsi" class="inline-block mb-2 text-sm font-bold text-slate-700">Description</label>
            <textarea id="deskripsi" name="deskripsi" rows="3"
              class="focus:shadow-soft-primary-outline text-sm leading-5.6 ease-soft block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-fuchsia-300 focus:outline-none"
              placeholder="Enter description (optional)">{{ $payrollDetail->deskripsi }}</textarea>
            @error('deskripsi')
              <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
          </div>
          <div class="flex justify-between items-center">
            <div>
              <a href="{{ route('admin.payroll-details.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white mr-2">
                Cancel
              </a>
            </div>
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-900 to-slate-800 text-white">
              Update
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection