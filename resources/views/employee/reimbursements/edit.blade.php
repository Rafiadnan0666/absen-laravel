@extends('layouts.employee')

@section('page-title', 'Edit Reimbursement')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-2xl font-black">Edit Reimbursement</h1>
        <a href="{{ route('employee.reimbursements.index') }}" class="neo-btn-secondary">Back</a>
    </div>

    @if($reimbursement->status != 'pending')
        <div class="neo-card mb-6">
            <p class="font-bold neo-alert-danger">This reimbursement request cannot be edited because it has been processed.</p>
        </div>
    @else
    <div class="neo-card">
        <form action="{{ route('employee.reimbursements.update', $reimbursement) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="neo-label">Amount (Rp)</label>
                <input type="number" name="jumlah" class="neo-input" required min="1000" value="{{ $reimbursement->jumlah }}">
                <p class="text-sm mt-1">Minimum amount: Rp 1,000</p>
            </div>

            <div class="mb-6">
                <label class="neo-label">Description</label>
                <textarea name="deskripsi" class="neo-input" rows="4" required>{{ $reimbursement->deskripsi }}</textarea>
            </div>

            <button type="submit" class="neo-btn-primary w-full text-lg">Update Request</button>
        </form>
    </div>
    @endif
@endsection