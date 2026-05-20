@extends('layouts.employee')

@section('page-title', 'My Payroll')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h1 class="text-2xl font-black">MY PAYROLL</h1>
    </div>

    <div class="neo-card">
        <div class="neo-table-container">
            <table class="neo-table">
                <thead>
                    <tr>
                        <th>Period</th>
                        <th>Basic Salary</th>
                        <th>Overtime</th>
                        <th>Deductions</th>
                        <th>Bonus</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payrolls as $payroll)
                    <tr>
                        <td class="font-bold">{{ \Carbon\Carbon::parse($payroll->periode_mulai)->format('M Y') }}</td>
                        <td>Rp {{ number_format($payroll->gaji_pokok, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($payroll->total_lembur, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($payroll->total_potongan, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($payroll->bonus, 0, ',', '.') }}</td>
                        <td class="font-bold">Rp {{ number_format($payroll->total_gaji, 0, ',', '.') }}</td>
                        <td>
                            @if($payroll->status_pembayaran == 'paid')
                                <span class="neo-badge neo-badge-green">PAID</span>
                            @else
                                <span class="neo-badge neo-badge-yellow">PENDING</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('employee.payrolls.show', $payroll) }}" class="neo-btn-secondary neo-btn-sm">View</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-8 font-bold">No payroll records</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $payrolls->links('vendor.pagination.neo') }}
        </div>
    </div>
@endsection