@extends('admin.dashboard.layout')

@section('title', 'View Leave - Admin')

@section('content')
<div class="flex flex-wrap -mx-3">
  <div class="flex-none w-full max-w-full p-3">
    <div class="relative flex flex-col min-w-0 mb-6 break-words bg-white border-0 border-transparent border-solid shadow-soft-xl rounded-2xl bg-clip-border">
      <div class="p-6 pb-0 mb-0 bg-white border-b-0 border-b-solid rounded-t-2xl border-b-transparent">
        <div class="flex justify-between items-center">
          <h6 class="text-xl font-bold">Leave Details</h6>
          <a href="{{ route('admin.leaves.index') }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-slate-600 to-slate-300 text-white">
            <i class="fas fa-arrow-left mr-1"></i> Back
          </a>
        </div>
      </div>
      <div class="flex-auto p-6">
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">ID</label>
          <p class="text-sm text-slate-500">{{ $leave->id }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Employee</label>
          <p class="text-sm text-slate-500">{{ $leave->user->nama_lengkap ?? 'N/A' }} ({{ $leave->user->email ?? 'N/A' }})</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Leave Type</label>
          <span class="bg-gradient-to-tl from-blue-600 to-cyan-400 px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white">{{ ucfirst($leave->tipe_cuti) }}</span>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Start Date</label>
          <p class="text-sm text-slate-500">{{ $leave->tanggal_mulai->format('d M Y') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">End Date</label>
          <p class="text-sm text-slate-500">{{ $leave->tanggal_selesai->format('d M Y') }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Reason</label>
          <p class="text-sm text-slate-500 whitespace-pre-wrap">{{ $leave->alasan }}</p>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Status</label>
          <span class="px-2 py-1 text-xs rounded-2xl inline-block whitespace-nowrap text-center text-white
            @if($leave->status_pengajuan == 'approved') bg-gradient-to-tl from-green-600 to-lime-400
            @elseif($leave->status_pengajuan == 'pending') bg-gradient-to-tl from-yellow-600 to-yellow-400
            @else bg-gradient-to-tl from-red-600 to-rose-400 @endif">
            {{ strtoupper($leave->status_pengajuan) }}
          </span>
        </div>
        <div class="mb-4">
          <label class="inline-block mb-2 text-sm font-bold text-slate-700">Approved By</label>
          <p class="text-sm text-slate-500">{{ $leave->approver->nama_lengkap ?? 'N/A' }}</p>
        </div>
        <div class="flex justify-end mt-6">
          <a href="{{ route('admin.leaves.edit', $leave) }}" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-blue-600 to-cyan-400 text-white mr-2">
            <i class="fas fa-edit mr-1"></i> Edit
          </a>
          @if($leave->status_pengajuan == 'pending')
            <form action="{{ route('admin.leaves.approve', $leave) }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-green-600 to-lime-400 text-white mr-2">
                <i class="fas fa-check mr-1"></i> Approve
              </button>
            </form>
            <form action="{{ route('admin.leaves.reject', $leave) }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-red-600 to-rose-400 text-white mr-2">
                <i class="fas fa-times mr-1"></i> Reject
              </button>
            </form>
          @endif
          <form action="{{ route('admin.leaves.destroy', $leave) }}" method="POST" class="inline" onsubmit="return confirm('Delete this leave request?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="inline-block px-6 py-3 mb-0 text-xs font-bold text-right uppercase align-middle transition-all border-0 rounded-lg cursor-pointer hover:scale-102 active:opacity-85 leading-pro ease-soft-in tracking-tight-soft bg-150 bg-x-25 bg-gradient-to-tl from-gray-600 to-slate-400 text-white">
              <i class="fas fa-trash mr-1"></i> Delete
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
