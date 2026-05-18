<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Reimbursement;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    public function index(Request $request)
    {
        $query = Reimbursement::with('user');

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($sub) => $sub->where('nama_lengkap', 'like', "%{$search}%"))
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $reimbursements = $query->latest()->paginate(20)->withQueryString();

        $totalReimb = Reimbursement::count();
        $pendingCount = Reimbursement::where('status', 'pending')->count();
        $approvedCount = Reimbursement::where('status', 'approved')->count();
        $rejectedCount = Reimbursement::where('status', 'rejected')->count();
        $totalAmount = Reimbursement::where('status', 'approved')->sum('jumlah');

        return view('hr.reimbursements.index', compact('reimbursements', 'totalReimb', 'pendingCount', 'approvedCount', 'rejectedCount', 'totalAmount'));
    }

    public function approve(Reimbursement $reimbursement)
    {
        $reimbursement->update(['status' => 'approved']);
        return back()->with('success', 'Reimbursement approved successfully');
    }

    public function reject(Reimbursement $reimbursement)
    {
        $reimbursement->update(['status' => 'rejected']);
        return back()->with('success', 'Reimbursement rejected successfully');
    }

    public function export(Request $request)
    {
        $query = Reimbursement::with('user');

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($sub) => $sub->where('nama_lengkap', 'like', "%{$search}%"))
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }
        if ($request->status) {
            $query->where('status', $request->status);
        }

        $reimbursements = $query->latest()->get();

        $filename = 'reimbursements-export-' . now()->format('Y-m-d') . '.csv';

        return response()->stream(function () use ($reimbursements) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Employee', 'Category', 'Amount', 'Description', 'Status']);
            foreach ($reimbursements as $r) {
                fputcsv($handle, [
                    $r->user->nama_lengkap ?? 'N/A',
                    $r->kategori ?? '',
                    $r->jumlah ?? 0,
                    $r->deskripsi ?? '',
                    $r->status ?? '',
                ]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
