@extends('hr.dashboard.layout')

@section('title', 'HR Leaves - ABS')
@section('page-title', 'Leaves')

@section('content')
    <h1 class="text-4xl font-black mb-6 text-slate-700">Leave Requests</h1>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="p-4 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
            <div class="flex justify-between items-center">
                <h6 class="mb-0 font-bold text-slate-700">All Leave Requests</h6>
                <a href="{{ route('leaves.create') }}" class="inline-block px-6 py-2 text-xs font-bold text-center text-white uppercase rounded-lg bg-gradient-to-tl from-green-600 to-lime-400 hover:scale-102 transition-all">New Request</a>
            </div>
        </div>
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th>Employee</th>
                            <th>Type</th>
                            <th>Period</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($leaves as $item)
                        <tr>
                            <td class="font-bold">{{ $item->user->nama_lengkap ?? 'N/A' }}</td>
                            <td>
                                <span class="neo-btn bg-blue-200 text-xs px-2 py-1">{{ strtoupper($item->tipe_cuti) }}</span>
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal_mulai)->format('d M') }} - {{ \Carbon\Carbon::parse($item->tanggal_selesai)->format('d M Y') }}</td>
                            <td>{{ Str::limit($item->alasan, 30) }}</td>
                            <td>
                                <span class="neo-btn text-xs px-2 py-1
                                    @if($item->status_pengajuan == 'approved') bg-green-200
                                    @elseif($item->status_pengajuan == 'pending') bg-yellow-200
                                    @else bg-red-200 @endif">
                                    {{ strtoupper($item->status_pengajuan) }}
                                </span>
                            </td>
                            <td>
                                @if($item->status_pengajuan == 'pending')
                                    <form action="{{ route('hr.leaves.approve', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn bg-green-200 text-xs">APPROVE</button>
                                    </form>
                                    <form action="{{ route('hr.leaves.reject', $item) }}" method="POST" class="inline">
                                        @csrf
                                        <button class="neo-btn bg-red-200 text-xs">REJECT</button>
                                    </form>
                                @else
                                    <span class="text-sm font-bold text-gray-500">Processed</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center font-bold text-gray-500 py-4">No leave requests</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $leaves->links() }}
                </div>
            </div>
        </main>
    </div>
</body>
</html>
