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

        $totalReimb = Reimbursement::count();
        $pendingCount = Reimbursement::where('status', 'pending')->count();
        $approvedCount = Reimbursement::where('status', 'approved')->count();
        $rejectedCount = Reimbursement::where('status', 'rejected')->count();
        $totalAmount = Reimbursement::where('status', 'approved')->sum('jumlah');

        return view('admin.reimbursements.index', compact(
            'reimbursements',
            'totalReimb', 'pendingCount', 'approvedCount', 'rejectedCount', 'totalAmount'
        ));
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

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.reimbursements.index')->with('error', 'No items selected');
        }

        Reimbursement::whereIn('id', $ids)->where('status', 'pending')
            ->update(['status' => 'approved', 'approved_by' => auth()->id()]);

        return redirect()->route('admin.reimbursements.index')->with('success', count($ids) . ' reimbursements approved');
    }

    public function bulkReject(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.reimbursements.index')->with('error', 'No items selected');
        }

        Reimbursement::whereIn('id', $ids)->where('status', 'pending')
            ->update(['status' => 'rejected', 'approved_by' => auth()->id()]);

        return redirect()->route('admin.reimbursements.index')->with('success', count($ids) . ' reimbursements rejected');
    }

    public function export(Request $request)
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

        $reimbursements = $query->latest()->get();

        $filename = 'reimbursements-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($reimbursements) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['ID', 'Employee', 'Amount', 'Description', 'Status', 'Approved By', 'Created At']);

            foreach ($reimbursements as $r) {
                fputcsv($handle, [
                    $r->id,
                    $r->user->nama_lengkap ?? 'N/A',
                    $r->jumlah,
                    $r->deskripsi,
                    $r->status,
                    $r->approver->nama_lengkap ?? '-',
                    $r->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
