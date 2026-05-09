@extends('layouts.employee')

@section('page-title', 'New Reimbursement')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">New Reimbursement</h1>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <form action="{{ route('employee.reimbursements.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="font-bold text-slate-700 block mb-2">Amount (Rp)</label>
                    <input type="number" name="jumlah" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" required min="1000" placeholder="Example: 500000">
                    <p class="text-sm text-slate-500 mt-1">Minimum amount: Rp 1,000</p>
                </div>

                <div class="mb-6">
                    <label class="font-bold text-slate-700 block mb-2">Description</label>
                    <textarea name="deskripsi" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" rows="4" required placeholder="Explain the reason for reimbursement..."></textarea>
                </div>

                <button type="submit" class="inline-block px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-600 to-violet-400 leading-pro text-xs ease-soft-in tracking-tight-soft w-full text-lg">
                    Submit Request
                </button>
            </form>
        </div>
    </div>
@endsection
