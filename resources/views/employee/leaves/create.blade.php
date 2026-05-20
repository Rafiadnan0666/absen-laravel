@extends('layouts.employee')

@section('page-title', 'New Leave Request')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h1 class="text-2xl font-black">NEW LEAVE REQUEST</h1>
        <a href="{{ route('employee.leaves.index') }}" class="neo-btn-secondary neo-btn-sm">BACK</a>
    </div>

    <div class="neo-card">
        <form action="{{ route('employee.leaves.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label class="neo-label">Leave Type</label>
                <select name="tipe_cuti" class="neo-select" required>
                    <option value="">Choose type...</option>
                    <option value="sick">Sick Leave</option>
                    <option value="annual">Annual Leave</option>
                    <option value="unpaid">Unpaid Leave</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="neo-label">Start Date</label>
                    <input type="date" name="tanggal_mulai" class="neo-input" required min="{{ today()->format('Y-m-d') }}">
                </div>
                <div>
                    <label class="neo-label">End Date</label>
                    <input type="date" name="tanggal_selesai" class="neo-input" required min="{{ today()->format('Y-m-d') }}">
                </div>
            </div>

            <div class="mb-6">
                <label class="neo-label">Reason</label>
                <textarea name="alasan" class="neo-input" rows="4" required placeholder="Explain your reason..."></textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="neo-btn-primary flex-1">Submit Request</button>
                <a href="{{ route('employee.leaves.index') }}" class="neo-btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection