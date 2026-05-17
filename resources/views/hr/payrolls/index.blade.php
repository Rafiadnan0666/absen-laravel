@extends('hr.dashboard.layout')

@section('title', 'HR Payrolls - ABS')
@section('page-title', 'Payrolls')

@section('content')
    <h1 class="neo-section-title">PAYROLL RECORDS</h1>

    <div class="neo-card">
        <div class="p-4 border-b-4 border-black">
            <div class="flex justify-between items-center">
                <h6 class="mb-0 font-bold text-xl">All Payroll Records</h6>
            </div>
        </div>
        <div class="p-4">
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Period</th>
                            <th>Base Salary</th>
                            <th>Overtime</th>
                            <th>Deductions</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payrolls as $item)
                        <tr>
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->periode_mulai)->format('M Y') }}</td>
                            <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="font-bold"><span class="neo-badge neo-badge-green">+ Rp {{ number_format($item->total_lembur, 0, ',', '.') }}</span></td>
                            <td class="font-bold"><span class="neo-badge neo-badge-red">- Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</span></td>
                            <td class="font-bold">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status_pembayaran == 'paid')
                                    <span class="neo-badge neo-badge-green">
                                        {{ strtoupper($item->status_pembayaran) }}
                                    </span>
                                @else
                                    <span class="neo-badge neo-badge-yellow">
                                        {{ strtoupper($item->status_pembayaran) }}
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center font-bold py-4">No payroll records</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $payrolls->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection