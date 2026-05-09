@extends('layouts.employee')

@section('page-title', 'Payslip')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black text-slate-700">Payslip</h1>
        <a href="{{ route('employee.payrolls.index') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-slate-600 to-slate-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
            Back
        </a>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="text-center mb-8">
                <h2 class="text-2xl font-black text-slate-700">{{ config('app.name', 'ABS') }} Company</h2>
                <p class="font-bold text-slate-600">Payslip for {{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('F Y') }}</p>
                <p class="text-sm text-slate-500">Period: {{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($payroll->periode_selesai)->format('d M Y') }}</p>
            </div>

            <div class="grid grid-cols-2 gap-8 mb-8">
                <div>
                    <p class="font-bold text-sm text-slate-400">Employee</p>
                    <p class="font-black text-lg text-slate-700">{{ $payroll->user->nama_lengkap }}</p>
                    <p class="text-sm text-slate-500">{{ $payroll->user->department->nama_department ?? '-' }}</p>
                    <p class="text-sm text-slate-500">{{ $payroll->user->jobTitle->nama_jabatan ?? '-' }}</p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-sm text-slate-400">Payment Status</p>
                    <span class="inline-block py-1 px-3 text-sm rounded-lg text-white font-bold bg-gradient-to-tl
                        @if($payroll->status_pembayaran == 'paid') from-green-600 to-lime-400
                        @elseif($payroll->status_pembayaran == 'processing') from-yellow-600 to-orange-400
                        @else from-red-600 to-rose-400 @endif">
                        {{ strtoupper($payroll->status_pembayaran) }}
                    </span>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 mb-6">
                <h3 class="text-xl font-black mb-4 text-slate-700">Earnings</h3>
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-bold text-slate-700">Basic Salary</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-bold text-slate-700">Overtime Pay</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($payroll->total_lembur, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-bold text-slate-700">Bonus</span>
                        <span class="font-bold text-slate-700">Rp {{ number_format($payroll->bonus, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-200 pt-6 mb-6">
                <h3 class="text-xl font-black mb-4 text-slate-700">Deductions</h3>
                <div class="flex justify-between">
                    <span class="font-bold text-slate-700">Total Deductions</span>
                    <span class="font-bold text-red-500">- Rp {{ number_format($payroll->total_potongan, 0, ',', '.') }}</span>
                </div>
            </div>

            @if($payroll->details && $payroll->details->count() > 0)
            <div class="border-t border-slate-200 pt-6 mb-6">
                <h3 class="text-xl font-black mb-4 text-slate-700">Details</h3>
                <div class="overflow-x-auto">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Description</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Type</th>
                                <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payroll->details as $detail)
                            <tr class="border-t border-slate-200">
                                <td class="px-4 py-3 text-sm text-slate-700">{{ $detail->deskripsi }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-block py-1 px-2 text-xs rounded-lg text-white font-bold bg-gradient-to-tl from-blue-600 to-cyan-400">
                                        {{ strtoupper($detail->tipe) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-sm font-bold text-slate-700">Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div class="border-t border-slate-200 pt-6">
                <div class="flex justify-between items-center">
                    <span class="text-2xl font-black text-slate-700">Total Salary</span>
                    <span class="text-3xl font-black text-slate-700">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
