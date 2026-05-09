@extends('layouts.employee')

@section('page-title', 'New Leave Request')

@section('content')
    <h1 class="text-4xl font-black mb-8 text-slate-700">New Leave Request</h1>

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <form action="{{ route('employee.leaves.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="font-bold text-slate-700 block mb-2">Leave Type</label>
                    <select name="tipe_cuti" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" required>
                        <option value="">Choose type...</option>
                        <option value="sick">Sick Leave</option>
                        <option value="annual">Annual Leave</option>
                        <option value="unpaid">Unpaid Leave</option>
                    </select>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="font-bold text-slate-700 block mb-2">Start Date</label>
                        <input type="date" name="tanggal_mulai" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" required min="{{ today()->format('Y-m-d') }}">
                    </div>
                    <div>
                        <label class="font-bold text-slate-700 block mb-2">End Date</label>
                        <input type="date" name="tanggal_selesai" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" required min="{{ today()->format('Y-m-d') }}">
                    </div>
                </div>

                <div class="mb-6">
                    <label class="font-bold text-slate-700 block mb-2">Reason</label>
                    <textarea name="alasan" class="border border-solid border-slate-300 rounded-lg px-4 py-2 focus:border-blue-500 focus:shadow-soft-primary-outline w-full" rows="4" required placeholder="Explain your reason..."></textarea>
                </div>

                <button type="submit" class="inline-block px-6 py-3 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro text-xs ease-soft-in tracking-tight-soft w-full text-lg">
                    Submit Request
                </button>
            </form>
        </div>
    </div>
@endsection
