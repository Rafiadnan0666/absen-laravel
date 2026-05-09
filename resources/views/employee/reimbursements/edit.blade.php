@extends('layouts.employee')

@section('page-title', 'Edit Reimbursement')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black text-slate-700">Edit Reimbursement</h1>
        <a href="{{ route('employee.reimbursements.index') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-slate-600 to-slate-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
            Back
        </a>
    </div>

    @if($reimbursement->status != 'pending')
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="flex-auto p-4">
                <p class="font-bold text-red-500">This reimbursement request cannot be edited because it has been processed.</p>
            </div>
        </div>
    @else
    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <form action="{{ route('employee.reimbursements.update', $reimbursement) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="mb-4">
                    <label class="font-bold text-slate-700 block mb-2">Amount (Rp)</label>
                    <input type="number" name="jumlah" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" required min="1000" value="{{ $reimbursement->jumlah }}">
                    <p class="text-sm text-slate-500 mt-1">Minimum amount: Rp 1,000</p>
                </div>

                <div class="mb-6">
                    <label class="font-bold text-slate-700 block mb-2">Description</label>
                    <textarea name="deskripsi" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" rows="4" required>{{ $reimbursement->deskripsi }}</textarea>
                </div>

                <button type="submit" class="inline-block px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-600 to-violet-400 leading-pro text-xs ease-soft-in tracking-tight-soft w-full text-lg">
                    Update Request
                </button>
            </form>
        </div>
    </div>
    @endif
@endsection
