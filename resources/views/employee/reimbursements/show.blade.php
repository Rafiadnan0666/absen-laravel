@extends('layouts.employee')

@section('page-title', 'Reimbursement Details')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h1 class="text-2xl font-black">REIMBURSEMENT DETAILS</h1>
        <a href="{{ route('employee.reimbursements.index') }}" class="neo-btn-secondary neo-btn-sm">BACK</a>
    </div>

    <div class="neo-card">
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="neo-label">Amount</p>
                <p class="font-black text-2xl">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</p>
            </div>
            <div>
                <p class="neo-label">Status</p>
                @if($reimbursement->status == 'approved')
                    <span class="neo-badge neo-badge-green">APPROVED</span>
                @elseif($reimbursement->status == 'pending')
                    <span class="neo-badge neo-badge-yellow">PENDING</span>
                @else
                    <span class="neo-badge neo-badge-red">REJECTED</span>
                @endif
            </div>
        </div>

        <div class="mb-6">
            <p class="neo-label mb-2">Description</p>
            <div class="neo-input min-h-[100px]">{{ $reimbursement->deskripsi }}</div>
        </div>

        @if($reimbursement->approvedBy)
        <div class="mb-6">
            <p class="neo-label mb-2">Processed By</p>
            <p class="font-bold">{{ $reimbursement->approvedBy->nama_lengkap }}</p>
        </div>
        @endif

        <div class="flex gap-4">
            <a href="{{ route('employee.reimbursements.index') }}" class="neo-btn-secondary flex-1">Back to List</a>
            @if($reimbursement->status == 'pending')
                <form action="{{ route('employee.reimbursements.destroy', $reimbursement) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="neo-btn-danger w-full" onclick="return confirm('Cancel this request?')">Cancel Request</button>
                </form>
            @endif
        </div>
    </div>
@endsection