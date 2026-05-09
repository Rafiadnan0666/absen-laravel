@extends('hr.dashboard.layout')

@section('title', 'HR Reimbursements - ABS')
@section('page-title', 'Reimbursements')

@section('content')
    <h1 class="text-4xl font-black mb-6 text-slate-700">Reimbursement Requests</h1>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <div class="flex justify-between items-center">
                <h6 class="mb-0 font-bold text-slate-700">All Reimbursement Requests</h6>
            </div>
        </div>
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Category</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reimbursements)
                        <tr>
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>
                                <span class="neo-btn bg-purple-200 text-xs px-2 py-1">{{ strtoupper($item->kategori) }}</span>
                            </td>
                            <td class="font-bold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>{{ Str::limit($item->deskripsi, 30) }}</td>
                            <td>
                                <span class="neo-btn text-xs px-2 py-1
                                    @if($item->status_pengajuan == 'approved') bg-green-200
                                    @elseif($item->status_pengajuan == 'pending') bg-yellow-200
                                    @else bg-red-200 @endif">
                                    {{ strtoupper($item->status_pengajuan) }}
                                </span>
                            </td>
                            <td>
                                @if($item->status_pengajuan == 'pending')
                                    <form action="{{ route('hr.reimbursements.approve', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn bg-green-200 text-xs">APPROVE</button>
                                    </form>
                                    <form action="{{ route('hr.reimbursements.reject', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn bg-red-200 text-xs">REJECT</button>
                                    </form>
                                @else
                                    <span class="text-sm font-bold text-gray-500">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center font-bold text-gray-500 py-4">No reimbursement requests</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $reimbursements->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
