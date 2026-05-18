<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reimbursement;
use App\Models\User;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    public function index(Request $request)
    {
        $query = Reimbursement::with('user', 'approver');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"))
                  ->orWhere('deskripsi', 'like', "%{$s}%");
            });
        }

        if ($request->filled('filterStatus')) {
            $query->where('status', $request->filterStatus);
        }

        if ($request->filled('dateFrom')) {
            $query->whereDate('created_at', '>=', $request->dateFrom);
        }

        if ($request->filled('dateTo')) {
            $query->whereDate('created_at', '<=', $request->dateTo);
        }

        if ($request->filled('amountMin')) {
            $query->where('jumlah', '>=', $request->amountMin);
        }

        if ($request->filled('amountMax')) {
            $query->where('jumlah', '<=', $request->amountMax);
        }

        $reimbursements = $query->latest()->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return view('admin.reimbursements._table', compact('reimbursements'))->render();
        }

        return view('admin.reimbursements.index', compact('reimbursements'));
    }

    public function create()
    {
        $users = User::where('status_akun', 'active')->get();
        return view('admin.reimbursements.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validated['status'] !== 'pending') {
            $validated['approved_by'] = auth()->id();
        }

        Reimbursement::create($validated);
        return redirect()->route('admin.reimbursements.index')->with('success', 'Reimbursement created');
    }

    public function show(Reimbursement $reimbursement)
    {
        return view('admin.reimbursements.show', compact('reimbursement'));
    }

    public function edit(Reimbursement $reimbursement)
    {
        $users = User::where('status_akun', 'active')->get();
        return view('admin.reimbursements.edit', compact('reimbursement', 'users'));
    }

    public function update(Request $request, Reimbursement $reimbursement)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        if ($validated['status'] !== $reimbursement->status && $validated['status'] !== 'pending') {
            $validated['approved_by'] = auth()->id();
        }

        $reimbursement->update($validated);
        return redirect()->route('admin.reimbursements.index')->with('success', 'Reimbursement updated');
    }

    public function destroy(Reimbursement $reimbursement)
    {
        $reimbursement->delete();
        return redirect()->route('admin.reimbursements.index')->with('success', 'Reimbursement deleted');
    }

    public function approve(Reimbursement $reimbursement)
    {
        $reimbursement->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);
        return redirect()->route('admin.reimbursements.index')->with('success', 'Reimbursement approved');
    }

    public function reject(Reimbursement $reimbursement)
    {
        $reimbursement->update([
            'status' => 'rejected',
            'approved_by' => auth()->id(),
        ]);
        return redirect()->route('admin.reimbursements.index')->with('success', 'Reimbursement rejected');
    }
}
