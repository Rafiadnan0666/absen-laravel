@extends('layouts.employee')

@section('page-title', 'My Leaves')

@section('content')
<div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4 fade-in-up">
    <h1 class="text-2xl font-black">MY LEAVES</h1>
    <a href="{{ route('employee.leaves.create') }}" class="neo-btn-primary neo-btn-sm pulse-glow">+ NEW LEAVE</a>
</div>

@if(session('success'))
    <div class="neo-alert-success mb-6 shake">{{ session('success') }}</div>
@endif

<x-advanced-filters :action="route('employee.leaves.index')" :filters="[
    'date_from' => ['type' => 'date', 'label' => 'Start From'],
    'date_to' => ['type' => 'date', 'label' => 'End To'],
    'status' => ['type' => 'select', 'label' => 'Status', 'options' => [
        'pending' => 'Pending',
        'approved' => 'Approved',
        'rejected' => 'Rejected',
    ]],
    'tipe_cuti' => ['type' => 'select', 'label' => 'Type', 'options' => [
        'sick' => 'Sick',
        'annual' => 'Annual',
        'unpaid' => 'Unpaid',
    ]],
]" />

<div class="neo-card fade-in-up fade-in-up-d2">
    <div class="neo-table-container">
        <table class="neo-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Period</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($leaves as $leave)
                <tr class="hover-lift" style="transition: transform 0.2s, box-shadow 0.2s;">
                    <td><span class="neo-badge neo-badge-cyan">{{ strtoupper($leave->tipe_cuti) }}</span></td>
                    <td class="font-bold">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
                    <td class="font-bold">{{ Str::limit($leave->alasan, 40) }}</td>
                    <td>
                        @if($leave->status_pengajuan == 'approved')
                            <span class="neo-badge neo-badge-green status-pulse">APPROVED</span>
                        @elseif($leave->status_pengajuan == 'pending')
                            <span class="neo-badge neo-badge-yellow">PENDING</span>
                        @else
                            <span class="neo-badge neo-badge-red">REJECTED</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('employee.leaves.show', $leave) }}" class="neo-btn-secondary neo-btn-sm">VIEW</a>
                        @if($leave->status_pengajuan == 'pending')
                            <form action="{{ route('employee.leaves.destroy', $leave) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="neo-btn-danger neo-btn-sm" onclick="return confirm('Cancel this leave request?')">CANCEL</button>
                            </form>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center py-12 font-bold">No leave records found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $leaves->links('vendor.pagination.neo') }}</div>
</div>
@endsection
