@extends('hr.dashboard.layout')

@section('title', 'HR Leaves - ABS')
@section('page-title', 'Leaves')

@section('content')
    <h1 class="neo-section-title">LEAVE REQUESTS</h1>

    <div class="neo-card mb-6">
        <div class="flex justify-between items-center p-4 border-b-4 border-black">
            <h2 class="font-black text-lg">All Leave Requests</h2>
            <a href="{{ route('employee.leaves.create') }}" class="neo-btn-primary neo-btn-sm pulse-glow">
                + NEW REQUEST
            </a>
        </div>

        <div class="p-4">
            <div class="neo-table-container">
                <table class="neo-table">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $item)
                        <tr>
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>
                                <span class="neo-label">{{ strtoupper($item->tipe_cuti) }}</span>
                            </td>
                            <td>
                                {{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}
                            </td>
                            <td>
                                @if($item->status_pengajuan == 'approved')
                                    <span class="neo-badge neo-badge-green">APPROVED</span>
                                @elseif($item->status_pengajuan == 'pending')
                                    <span class="neo-badge neo-badge-yellow">PENDING</span>
                                @else
                                    <span class="neo-badge neo-badge-red">REJECTED</span>
                                @endif
                            </td>
                            <td>
                                @if($item->status_pengajuan == 'pending')
                                    <form action="{{ route('hr.leaves.approve', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="neo-btn-primary neo-btn-sm">APPROVE</button>
                                    </form>
                                    <form action="{{ route('hr.leaves.reject', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="neo-btn-danger neo-btn-sm">REJECT</button>
                                    </form>
                                @else
                                    <span class="neo-label">PROCESSED</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center font-bold">No leave requests</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $leaves->links('vendor.pagination.neo') }}
            </div>
        </div>
    </div>
@endsection
