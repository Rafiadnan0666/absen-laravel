@extends('layouts.employee')

@section('page-title', 'My Reimbursements')

@section('content')
<div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
    <h1 class="text-2xl font-black">MY REIMBURSEMENTS</h1>
    <a href="{{ route('employee.reimbursements.create') }}" class="neo-btn-primary">+ NEW REIMBURSEMENT</a>
</div>

@if(session('success'))
    <div class="neo-alert-success mb-6">{{ session('success') }}</div>
@endif

<div class="neo-card">
    <div class="neo-table-container">
        <table class="neo-table">
            <thead>
                <tr>
                    <th>Amount</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reimbursements as $reimbursement)
                <tr>
                    <td class="font-black text-lg">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</td>
                    <td class="font-bold">{{ Str::limit($reimbursement->deskripsi, 50) }}</td>
                    <td>
                        @if($reimbursement->status == 'approved')
                            <span class="neo-badge neo-badge-green">APPROVED</span>
                        @elseif($reimbursement->status == 'pending')
                            <span class="neo-badge neo-badge-yellow">PENDING</span>
                        @else
                            <span class="neo-badge neo-badge-red">REJECTED</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('employee.reimbursements.show', $reimbursement) }}" class="neo-btn-secondary neo-btn-sm">VIEW</a>
                        @if($reimbursement->status == 'pending')
                            <form action="{{ route('employee.reimbursements.destroy', $reimbursement) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="neo-btn-danger neo-btn-sm" onclick="return confirm('Cancel this request?')">CANCEL</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="text-center py-8 font-bold">No reimbursement records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $reimbursements->links() }}</div>
</div>
@endsection