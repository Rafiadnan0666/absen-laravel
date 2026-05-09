@extends('layouts.employee')

@section('page-title', 'My Reimbursements')

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-black text-slate-700">My Reimbursements</h1>
        <a href="{{ route('employee.reimbursements.create') }}" class="inline-block px-6 py-2 mb-0 font-bold text-center text-white uppercase align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-purple-600 to-violet-400 leading-pro text-xs ease-soft-in tracking-tight-soft">
            + New Reimbursement
        </a>
    </div>

    @if(session('success'))
        <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border mb-6">
            <div class="flex-auto p-4">
                <p class="font-bold text-slate-700">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="relative flex flex-col min-w-0 break-words bg-white shadow-soft-xl rounded-2xl bg-clip-border">
        <div class="flex-auto p-4">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Amount</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Description</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-bold text-slate-400 uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reimbursements as $reimbursement)
                        <tr class="border-t border-slate-200">
                            <td class="px-4 py-3 text-sm font-bold text-slate-700">Rp {{ number_format($reimbursement->jumlah, 0, ',', '.') }}</td>
                            <td class="px-4 py-3 text-sm text-slate-500">{{ Str::limit($reimbursement->deskripsi, 50) }}</td>
                            <td class="px-4 py-3">
                                <span class="inline-block py-1 px-2 text-xs rounded-lg text-white font-bold bg-gradient-to-tl
                                    @if($reimbursement->status == 'approved') from-green-600 to-lime-400
                                    @elseif($reimbursement->status == 'pending') from-yellow-600 to-orange-400
                                    @else from-red-600 to-rose-400 @endif">
                                    {{ strtoupper($reimbursement->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <a href="{{ route('employee.reimbursements.show', $reimbursement) }}" class="inline-block px-3 py-1 text-xs font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-blue-600 to-cyan-400 leading-pro ease-soft-in tracking-tight-soft">
                                    View
                                </a>
                                @if($reimbursement->status == 'pending')
                                    <form action="{{ route('employee.reimbursements.destroy', $reimbursement) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-block px-3 py-1 text-xs font-bold text-center text-white align-middle transition-all bg-transparent border-0 rounded-lg shadow-none cursor-pointer hover:scale-102 active:shadow-soft-xs bg-gradient-to-tl from-red-600 to-rose-400 leading-pro ease-soft-in tracking-tight-soft" onclick="return confirm('Cancel this request?')">
                                            Cancel
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-slate-400">No reimbursement records</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $reimbursements->links() }}
            </div>
        </div>
    </div>
@endsection
