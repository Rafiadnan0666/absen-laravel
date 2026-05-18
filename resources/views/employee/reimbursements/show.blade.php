@extends('layouts.employee')

@section('page-title', 'Reimbursement Details')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black text-slate-700">Reimbursement Details</h1>
        <a href="{{ route('employee.reimbursements.index') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-slate-600 to-slate-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
            Back
        </a>
    </div>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="grid grid-cols-2 gap-6 mb-6">
                <div>
                    <p class="font-bold text-sm text-slate-400">Amount</p>
                    <p class="font-black text-2xl text-slate-700">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</p>
                </div>
                <div>
                    <p class="font-bold text-sm text-slate-400">Status</p>
                    <span class="inline-block py-1 px-3 text-sm rounded-lg text-white font-bold bg-gradient-to-tl
                        @if($reimbursement->status == 'approved') from-green-600 to-lime-400
                         @elseif($reimbursement->status == 'pending') from-blue-600 to-indigo-500
                        @else from-red-600 to-rose-400 @endif">
                        {{ strtoupper($reimbursement->status) }}
                    </span>
                </div>
            </div>

            <div class="mb-6">
                <p class="font-bold text-sm text-slate-400 mb-2">Description</p>
                <div class="relative w-full px-5 py-4 mx-auto overflow-hidden bg-slate-50 border border-solid shadow-none rounded-2xl border-slate-100 bg-clip-border">
                    <p class="text-slate-700">{{ $reimbursement->deskripsi }}</p>
                </div>
            </div>

            @if($reimbursement->approvedBy)
            <div class="mb-6">
                <p class="font-bold text-sm text-slate-400 mb-2">Processed By</p>
                <p class="font-bold text-slate-700">{{ $reimbursement->approvedBy->nama_lengkap }}</p>
            </div>
            @endif

            <div class="flex space-x-4">
                <a href="{{ route('employee.reimbursements.index') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-slate-600 to-slate-400 leading-pro text-xs ease-soft-in tracking-tight-soft flex-1">
                    Back to List
                </a>
                @if($reimbursement->status == 'pending')
                    <form action="{{ route('employee.reimbursements.destroy', $reimbursement) }}" method="POST" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-red-600 to-rose-400 leading-pro text-xs ease-soft-in tracking-tight-soft w-full" onclick="return confirm('Cancel this request?')">
                            Cancel Request
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
