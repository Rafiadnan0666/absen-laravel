@extends('layouts.employee')

@section('page-title', 'My Leaves')

@section('content')
<div class="flex justify-between items-center mb-6 border-b-3 border-black pb-4">
    <h1 class="text-2xl font-black">MY LEAVES</h1>
    <a href="{{ route('employee.leaves.create') }}" class="neo-btn-primary">+ NEW LEAVE</a>
</div>

@if(session('success'))
    <div class="neo-alert-success mb-6">{{ session('success') }}</div>
@endif

<div class="neo-card">
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
                <tr>
                    <td><span class="neo-badge neo-badge-cyan">{{ strtoupper($leave->tipe_cuti) }}</span></td>
                    <td class="font-bold">{{ \Carbon\Carbon::parse($leave->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($leave->tanggal_selesai)->format('d M Y') }}</td>
                    <td class="font-bold">{{ Str::limit($leave->alasan, 40) }}</td>
                    <td>
                        @if($leave->status_pengajuan == 'approved')
                            <span class="neo-badge neo-badge-green">APPROVED</span>
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
                <tr><td colspan="5" class="text-center py-8 font-bold">No leave records</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $leaves->links() }}</div>
</div>
@endsection