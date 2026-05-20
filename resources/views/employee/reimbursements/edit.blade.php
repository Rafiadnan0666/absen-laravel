@extends('layouts.employee')

@section('page-title', 'Edit Reimbursement')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h1 class="text-2xl font-black">EDIT REIMBURSEMENT</h1>
        <a href="{{ route('employee.reimbursements.index') }}" class="neo-btn-secondary neo-btn-sm">BACK</a>
    </div>

    @if($reimbursement->status != 'pending')
        <div class="neo-alert-danger mb-6">This reimbursement request cannot be edited because it has been processed.</div>
    @else
    <div class="neo-card">
        <form action="{{ route('employee.reimbursements.update', $reimbursement) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="neo-label">Category</label>
                <select name="kategori" class="neo-input" required>
                    <option value="">Select Category</option>
                    <option value="transport" {{ $reimbursement->kategori == 'transport' ? 'selected' : '' }}>Transportation</option>
                    <option value="medical" {{ $reimbursement->kategori == 'medical' ? 'selected' : '' }}>Medical</option>
                    <option value="meal" {{ $reimbursement->kategori == 'meal' ? 'selected' : '' }}>Meal</option>
                    <option value="supplies" {{ $reimbursement->kategori == 'supplies' ? 'selected' : '' }}>Office Supplies</option>
                    <option value="training" {{ $reimbursement->kategori == 'training' ? 'selected' : '' }}>Training</option>
                    <option value="other" {{ $reimbursement->kategori == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>

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