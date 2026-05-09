@extends('layouts.employee')

@section('page-title', 'My Payroll')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">My Payroll</h1>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Period</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Basic Salary</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Overtime</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Deductions</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Bonus</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $payroll)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-3 text-sm font-semibold text-slate-700">{{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('M Y') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">Rp {{ number_format($payroll->total_lembur, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">Rp {{ number_format($payroll->total_potongan, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">Rp {{ number_format($payroll->bonus, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm font-bold text-slate-700">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block py-1 px-2 text-xs rounded-lg text-white font-bold bg-gradient-to-tl
                                    @if($payroll->status_pembayaran == 'paid') from-green-600 to-lime-400
                                    @elseif($payroll->status_pembayaran == 'processing') from-yellow-600 to-orange-400
                                    @else from-red-600 to-rose-400 @endif">
                                    {{ strtoupper($payroll->status_pembayaran) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('employee.payrolls.show', $payroll) }}" class="inline-block px-3 py-1 text-xs font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro ease-soft-in tracking-tight-soft">
                                    View
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="px-4 py-8 text-center text-slate-400">No payroll records</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $payrolls->links() }}
            </div>
        </div>
    </div>
@endsection
