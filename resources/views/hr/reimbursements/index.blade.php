@extends('hr.dashboard.layout')

@section('title', 'HR Reimbursements - ABS')
@section('page-title', 'Reimbursements')

@section('content')
    <h1 class="neo-section-title">REIMBURSEMENT REQUESTS</h1>

    <div class="neo-card">
        <div class="p-4 border-b-4 border-black">
            <h6 class="mb-0 font-bold text-xl">All Reimbursement Requests</h6>
        </div>
        <div class="p-4">
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reimbursements as $item)
                        <tr>
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td class="font-bold">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                            <td>
                                <span class="neo-label">{{ strtoupper($item->kategori) }}</span>
                            </td>
                            <td>
                                @if($item->status_pengajuan == 'approved')
                                    <span class="neo-badge neo-badge-green">APPROVED</span>
                                @elseif($item->status_pengajuan == 'pending')
                                    <span class="neo-badge neo-badge-yellow">PENDING</span>
                                @else
                                    <span class="neo-badge neo-badge-red">REJECTED</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status_pengajuan == 'pending')
                                    <form action="{{ route('hr.reimbursements.approve', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn-primary neo-btn-sm">APPROVE</button>
                                    </form>
                                    <form action="{{ route('hr.reimbursements.reject', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn-danger neo-btn-sm">REJECT</button>
                                    </form>
                                @else
                                    <span class="text-sm font-bold">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center font-bold py-4">No reimbursement requests</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4 border-t-4 border-black p-4">
                {{ $reimbursements->links() }}
            </div>
        </div>
    </div>
@endsection