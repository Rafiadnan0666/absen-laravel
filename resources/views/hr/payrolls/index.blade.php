@extends('hr.dashboard.layout')

@section('title', 'HR Payrolls - ABS')
@section('page-title', 'Payrolls')

@section('content')
    <h1 class="text-4xl font-black mb-6 text-slate-700">Payroll Records</h1>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <div class="flex justify-between items-center">
                <h6 class="mb-0 font-bold text-slate-700">All Payroll Records</h6>
            </div>
        </div>
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
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
                            <td class="text-green-600">+ Rp {{ number_format($item->total_lembur, 0, ',', '.') }}</td>
                            <td class="text-red-600">- Rp {{ number_format($item->total_potongan, 0, ',', '.') }}</td>
                            <td class="font-bold">Rp {{ number_format($item->total_gaji, 0, ',', '.') }}</td>
                            <td>
                                <span class="neo-btn text-xs px-2 py-1 {{ $item->status_pembayaran == 'paid' ? 'bg-green-200' : 'bg-yellow-200' }}">
                                    {{ strtoupper($item->status_pembayaran) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center font-bold text-gray-500 py-4">No payroll records</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $payrolls->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
