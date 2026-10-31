@extends('admin.dashboard.layout')

@section('title', 'View Payroll Detail - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Payroll Detail</h6>
          <a href="{{ route('admin.payroll-details.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">ID</label>
          <p class="text-sm text-slate-500">{{ $payrollDetail->id }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Payroll</label>
          <p class="text-sm text-slate-500">{{ $payrollDetail->payroll->user->nama_lengkap ?? 'N/A' }} ({{ $payrollDetail->payroll->periode_mulai->format('M Y') }})</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Type</label>
          <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
            @if($payrollDetail->tipe == 'base') bg-gradient-to-tl from-blue-600 to-indigo-500
            @elseif($payrollDetail->tipe == 'overtime') bg-gradient-to-tl from-green-600 to-lime-400
            @elseif($payrollDetail->tipe == 'penalty') bg-gradient-to-tl from-red-600 to-rose-400
            @else bg-gradient-to-tl from-purple-600 to-pink-500 @endif">
            {{ ucfirst($payrollDetail->tipe) }}
          </span>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Description</label>
          <p class="text-sm text-slate-500 whitespace-pre-wrap">{{ $payrollDetail->deskripsi ?? '-' }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Amount</label>
          <p class="text-sm font-bold text-slate-700">{{ $payrollDetail->tipe == 'penalty' ? '-' : '+' }}Rp {{ number_format($payrollDetail->jumlah, 0, ',', '.') }}</p>
        </div>
        <div class="flex justify-end mt-6">
          <a href="{{ route('admin.payroll-details.edit', $payrollDetail) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-2">
            <i class="fas fa-edit mr-1"></i> Edit
          </a>
          <form action="{{ route('admin.payroll-details.destroy', $payrollDetail) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll detail?')">
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