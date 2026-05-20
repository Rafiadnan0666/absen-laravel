@extends('layouts.employee')

@section('page-title', 'New Reimbursement')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h1 class="text-2xl font-black">NEW REIMBURSEMENT</h1>
        <a href="{{ route('employee.reimbursements.index') }}" class="neo-btn-secondary neo-btn-sm">BACK</a>
    </div>

    <div class="neo-card">
        <form action="{{ route('employee.reimbursements.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="neo-label">Category</label>
                <select name="kategori" class="neo-input" required>
                    <option value="">Select Category</option>
                    <option value="transport">Transportation</option>
                    <option value="medical">Medical</option>
                    <option value="meal">Meal</option>
                    <option value="supplies">Office Supplies</option>
                    <option value="training">Training</option>
                    <option value="other">Other</option>
                </select>
            </div>

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