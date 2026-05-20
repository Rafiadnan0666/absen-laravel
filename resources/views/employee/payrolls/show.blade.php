@extends('layouts.employee')

@section('page-title', 'Payslip')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h1 class="text-2xl font-black">PAYSLIP</h1>
        <a href="{{ route('employee.payrolls.index') }}" class="neo-btn-secondary neo-btn-sm">BACK</a>
    </div>

    <div class="neo-card">
        <div class="text-center mb-8">
            <h2 class="text-2xl font-black">{{ config('app.name', 'ABS') }} Company</h2>
            <p class="font-bold">Payslip for {{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('F Y') }}</p>
            <p class="text-sm">Period: {{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('d M Y') }} - {{ \Carbon\Carbon::parse($payroll->periode_selesai)->format('d M Y') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <p class="neo-label">Employee</p>
                <p class="font-black text-lg">{{ $payroll->user->nama_lengkap }}</p>
                <p class="text-sm">{{ $payroll->user->department->nama_department ?? '-' }}</p>
                <p class="text-sm">{{ $payroll->user->jobTitle->nama_jabatan ?? '-' }}</p>
            </div>
            <div class="text-right">
                <p class="neo-label">Payment Status</p>
                <span class="neo-badge neo-badge-green">{{ strtoupper($payroll->status_pembayaran) }}</span>
            </div>
        </div>

        <div class="border-t-3 border-black pt-6 mb-6">
            <h3 class="text-xl font-black mb-4">Earnings</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="font-bold">Basic Salary</span>
                    <span class="font-bold">Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-bold">Overtime Pay</span>
                    <span class="font-bold">Rp {{ number_format($payroll->total_lembur, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="font-bold">Bonus</span>
                    <span class="font-bold">Rp {{ number_format($payroll->bonus, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="border-t-3 border-black pt-6 mb-6">
            <h3 class="text-xl font-black mb-4">Deductions</h3>
            <div class="flex justify-between">
                <span class="font-bold">Total Deductions</span>
                <span class="font-bold"><span class="neo-badge neo-badge-red">- Rp {{ number_format($payroll->total_potongan, 0, ',', '.') }}</span></span>
            </div>
        </div>

        @if($payroll->details && $payroll->details->count() > 0)
        <div class="border-t-3 border-black pt-6 mb-6">
            <h3 class="text-xl font-black mb-4">Details</h3>
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th>Type</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($payroll->details as $detail)
                        <tr>
                            <td>{{ $detail->deskripsi }}</td>
                            <td><span class="neo-badge neo-badge-cyan">{{ strtoupper($detail->tipe) }}</span></td>
                            <td class="font-bold">Rp {{ number_format($detail->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="border-t-3 border-black pt-6">
            <div class="flex justify-between items-center">
                <span class="text-2xl font-black">Total Salary</span>
                <span class="text-3xl font-black">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>
@endsection