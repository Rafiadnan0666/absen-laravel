@extends('hr.dashboard.layout')

@section('title', 'HR Payrolls - ABS')
@section('page-title', 'Payrolls')

@section('content')
    <h1 class="neo-section-title fade-in-up">PAYROLL RECORDS</h1>

    @if(session('success'))
        <div class="neo-alert-success mb-6 shake">{{ session('success') }}</div>
    @endif

    <x-advanced-filters :action="route('hr.payrolls.index')" :filters="[
        'date_from' => ['type' => 'date', 'label' => 'Period From'],
        'date_to' => ['type' => 'date', 'label' => 'Period To'],
        'status_pembayaran' => ['type' => 'select', 'label' => 'Status', 'options' => [
            'pending' => 'Pending',
            'paid' => 'Paid',
        ]],
        'user_id' => ['type' => 'select', 'label' => 'Employee', 'options' => $users->pluck('nama_lengkap', 'id')->toArray()],
    ]" />

    <div class="neo-card fade-in-up fade-in-up-d2">
        <div class="flex justify-between items-center p-4 border-b-3 border-black">
            <h2 class="font-black text-xl">All Payroll Records</h2>
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
                        <tr class="hover-lift" style="transition: transform 0.2s, box-shadow 0.2s;">
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->periode_mulai)->format('M Y') }}</td>
                            <td>Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="font-bold"><span class="neo-badge neo-badge-green">+ Rp {{ number_format($item->total_lembur, 0, ',', '.') }}</span></td>
                            <td class="font-bold"><span class="neo-badge neo-badge-red">- Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</span></td>
                            <td class="font-bold">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                            <td>
                                @if($item->status_pembayaran == 'paid')
                                    <span class="neo-badge neo-badge-green status-pulse">{{ strtoupper($item->status_pembayaran) }}</span>
                                @else
                                    <span class="neo-badge neo-badge-yellow">{{ strtoupper($item->status_pembayaran) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center font-bold py-8">No payroll records</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $payrolls->links('vendor.pagination.neo') }}
            </div>
        </div>
    </div>
@endsection
