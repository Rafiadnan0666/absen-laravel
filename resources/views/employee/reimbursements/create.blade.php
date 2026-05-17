@extends('layouts.employee')

@section('page-title', 'New Reimbursement')

@section('content')
    <h1 class="text-4xl font-black mb-8">New Reimbursement</h1>

    <div class="neo-card">
        <form action="{{ route('employee.reimbursements.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="neo-label">Amount (Rp)</label>
                <input type="number" name="jumlah" class="neo-input" required min="1000" placeholder="Example: 100000">
                <p class="text-sm mt-1">Minimum amount: Rp 1,000</p>
            </div>

            <div class="mb-6">
                <label class="neo-label">Description</label>
                <textarea name="deskripsi" class="neo-input" rows="4" required placeholder="Explain the reason for reimbursement..."></textarea>
            </div>

            <button type="submit" class="neo-btn-primary w-full text-lg">Submit Request</button>
        </form>
    </div>
@endsection