@extends('hr.dashboard.layout')

@section('title', 'HR Payrolls - ABS')
@section('page-title', 'Payrolls')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">

    <!-- Stats Recap -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-4">
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Total Records</p>
        <p class="text-lg font-bold text-slate-700 mb-0">{{ $totalPayroll }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-green-500">Paid</p>
        <p class="text-lg font-bold text-green-600 mb-0">{{ $totalPaid }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-amber-500">Pending</p>
        <p class="text-lg font-bold text-amber-600 mb-0">{{ $totalPending }}</p>
      </div>
      <div class="bg-white shadow-soft-xl rounded-2xl p-3 text-center">
        <p class="mb-0 text-xs font-semibold text-slate-400">Total Amount</p>
        <p class="text-lg font-bold text-purple-600 mb-0">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
      </div>
    </div>

    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-3">
          <h6 class="text-xl font-bold">Payroll Records</h6>
          <div class="flex items-center gap-2 w-full sm:w-auto flex-wrap">
            <form method="GET" action="{{ route('hr.payrolls.index') }}" class="flex items-center gap-2 flex-wrap">
              <input type="text" name="search" value="{{ request('search') }}" placeholder="Search employee..." class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-32">
              <select name="status" class="px-3 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
              </select>
              <input type="month" name="periode" value="{{ request('periode') }}" class="px-2 py-2 text-xs border border-slate-200 rounded-lg focus:border-purple-400 outline-none bg-white w-28">
              <button type="submit" class="px-3 py-2 text-xs font-bold text-white uppercase rounded-lg bg-gradient-to-tl from-purple-700 to-pink-500 hover:scale-102 transition-all">
                <i class="fas fa-search"></i>
              </button>
            </form>
          </div>
        </div>
      </div>
      <div class="flex-auto p-6 px-0 pt-0 pb-2 relative">
        @if(session('success'))
          <div class="p-4 mb-4 mx-6 text-sm text-green-800 rounded-lg bg-green-50" role="alert">{{ session('success') }}</div>
        @endif
        <div class="overflow-x-auto">
          <table class="items-center w-full mb-0 align-top border-gray-200 text-slate-500">
            <thead class="align-bottom">
              <tr>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Employee</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Period</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Base Salary</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Overtime</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Deductions</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Total</th>
                <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-gray-200 shadow-none text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-70">Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($payrolls as $item)
              <tr>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-semibold leading-normal text-sm">{{ $item->user->nama_lengkap ?? 'N/A' }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-slate-500">{{ \Carbon\Carbon::parse($item->periode_mulai)->format('M Y') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-slate-600">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-green-600">+ Rp {{ number_format($item->total_lembur, 0, ',', '.') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 leading-normal text-xs text-red-600">- Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <p class="mb-0 font-bold leading-normal text-sm text-slate-700">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</p>
                </td>
                <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap shadow-transparent">
                  <span class="px-3 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white font-bold
                    @if($item->status_pembayaran == 'paid') bg-gradient-to-tl from-green-600 to-lime-400
                    @else bg-gradient-to-tl from-amber-500 to-yellow-400 @endif">
                    {{ strtoupper($item->status_pembayaran) }}
                  </span>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="p-4 text-center text-slate-400">No payroll records</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
        <div class="px-4 pt-3">
          {{ $payrolls->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
