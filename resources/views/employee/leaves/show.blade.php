@extends('layouts.employee')

@section('page-title', 'Leave Details')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-black">Leave Details</h1>
        <a href="{{ route('employee.leaves.index') }}" class="neo-btn-secondary">Back</a>
    </div>

    <div class="neo-card">
        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <p class="neo-label">Type</p>
                <p class="font-black text-lg">{{ strtoupper($leave->tipe_cuti) }}</p>
            </div>
            <div>
                <p class="neo-label">Status</p>
                @if($leave->status_pengajuan == 'approved')
                    <span class="neo-badge neo-badge-green">APPROVED</span>
                @elseif($leave->status_pengajuan == 'pending')
                    <span class="neo-badge neo-badge-yellow">PENDING</span>
                @else
                    <span class="neo-badge neo-badge-red">REJECTED</span>
                @endif
            </div>
            <div>
                <p class="neo-label">Start Date</p>
                <p class="font-bold">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M Y') }}</p>
            </div>
            <div>
                <p class="neo-label">End Date</p>
                <p class="font-bold">{{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</p>
            </div>
        </div>

        <div class="mb-6">
            <p class="neo-label mb-2">Reason</p>
            <div class="neo-input min-h-[100px]">{{ $leave->alasan }}</div>
        </div>

        @if($leave->approvedBy)
        <div class="mb-6">
            <p class="neo-label mb-2">Processed By</p>
            <p class="font-bold">{{ $leave->approvedBy->nama_lengkap }}</p>
        </div>
        @endif

        <div class="flex gap-4">
            <a href="{{ route('employee.leaves.index') }}" class="neo-btn-secondary flex-1">Back to List</a>
            @if($leave->status_pengajuan == 'pending')
                <form action="{{ route('employee.leaves.destroy', $leave) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="neo-btn-danger w-full" onclick="return confirm('Cancel this leave request?')">Cancel Request</button>
                </form>
            @endif
        </div>
    </div>
@endsection