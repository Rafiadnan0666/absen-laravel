@extends('admin.dashboard.layout')

@section('title', 'View Payroll - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Payroll Details</h6>
          <a href="{{ route('admin.payrolls.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">ID</label>
          <p class="text-sm text-slate-500">{{ $payroll->id }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Employee</label>
          <p class="text-sm text-slate-500">{{ $payroll->user->nama_lengkap ?? 'N/A' }} ({{ $payroll->user->email ?? 'N/A' }})</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Period</label>
          <p class="text-sm text-slate-500">{{ $payroll->periode_mulai->format('d M Y') }} - {{ $payroll->periode_selesai->format('d M Y') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Base Salary</label>
          <p class="text-sm text-slate-500">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Overtime Pay</label>
          <p class="text-sm text-green-600">+ Rp {{ number_format($payroll->total_lembur ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Deductions</label>
          <p class="text-sm text-red-600">- Rp {{ number_format($payroll->total_potongan ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Bonus</label>
          <p class="text-sm text-slate-500">Rp {{ number_format($payroll->bonus ?? 0, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Total Salary</label>
          <p class="text-sm font-bold text-slate-700">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Payment Status</label>
          <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
            @if($payroll->status_pembayaran == 'paid') bg-gradient-to-tl from-green-600 to-lime-400
                         @else bg-gradient-to-tl from-blue-600 to-indigo-500 @endif">
            {{ strtoupper($payroll->status_pembayaran) }}
          </span>
        </div>
        @if($payroll->details && $payroll->details->count() > 0)
        <div class="mt-6">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Payroll Details</label>
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Description</th>
                <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Amount</th>
                <th class="px-4 py-2 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 text-xxs tracking-none whitespace-nowrap text-slate-400 opacity-70">Type</th>
              </tr>
            </thead>
            <tbody>
              @foreach($payroll->details as $detail)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs">{{ $detail->deskripsi }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs">Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white {{ $detail->tipe == 'allowance' ? 'bg-gradient-to-tl from-green-600 to-lime-400' : 'bg-gradient-to-tl from-red-600 to-rose-400' }}">
                    {{ ucfirst($detail->tipe) }}
                  </span>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif
        <div class="flex justify-end mt-6">
          <a href="{{ route('admin.payrolls.edit', $payroll) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-2">
            <i class="fas fa-edit mr-1"></i> Edit
          </a>
          <form action="{{ route('admin.payrolls.destroy', $payroll) }}" method="POST" class="inline" onsubmit="return confirm('Delete this payroll?')">
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
