@extends('layouts.employee')

@section('page-title', 'Edit Leave')

@section('content')
    <div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
        <h1 class="text-2xl font-black">EDIT LEAVE</h1>
        <a href="{{ route('employee.leaves.index') }}" class="neo-btn-secondary neo-btn-sm">BACK</a>
    </div>

    @if($leave->status_pengajuan != 'pending')
        <div class="neo-alert-danger mb-6">This leave request cannot be edited because it has been processed.</div>
    @else
    <div class="neo-card">
        <form action="{{ route('employee.leaves.update', $leave) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="neo-label">Leave Type</label>
                <select name="tipe_cuti" class="neo-select" required>
                    <option value="sick" {{ $leave->tipe_cuti == 'sick' ? 'selected' : '' }}>Sick Leave</option>
                    <option value="annual" {{ $leave->tipe_cuti == 'annual' ? 'selected' : '' }}>Annual Leave</option>
                    <option value="unpaid" {{ $leave->tipe_cuti == 'unpaid' ? 'selected' : '' }}>Unpaid Leave</option>
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="neo-label">Start Date</label>
                    <input type="date" name="tanggal_mulai" class="neo-input" required value="{{ $leave->tanggal_mulai->format('Y-m-d') }}">
                </div>
                <div>
                    <label class="neo-label">End Date</label>
                    <input type="date" name="tanggal_selesai" class="neo-input" required value="{{ $leave->tanggal_selesai->format('Y-m-d') }}">
                </div>
            </div>

            <div class="mb-6">
                <label class="neo-label">Reason</label>
                <textarea name="alasan" class="neo-input" rows="4" required>{{ $leave->alasan }}</textarea>
            </div>

            <button type="submit" class="neo-btn-primary w-full text-lg">Update Request</button>
        </form>
    </div>
    @endif
@endsection