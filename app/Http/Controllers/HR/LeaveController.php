<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('user');

        if ($search = $request->search) {
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$search}%"));
        }
        if ($request->type) {
            $query->where('tipe_cuti', $request->type);
        }
        if ($request->status) {
            $query->where('status_pengajuan', $request->status);
        }

        $leaves = $query->latest()->paginate(20)->withQueryString();

        $totalLeaves = Leave::count();
        $pendingCount = Leave::where('status_pengajuan', 'pending')->count();
        $approvedCount = Leave::where('status_pengajuan', 'approved')->count();
        $rejectedCount = Leave::where('status_pengajuan', 'rejected')->count();

        return view('hr.leaves.index', compact('leaves', 'totalLeaves', 'pendingCount', 'approvedCount', 'rejectedCount'));
    }

    public function approve(Leave $leave)
    {
        $leave->update(['status_pengajuan' => 'approved']);
        return back()->with('success', 'Leave approved successfully');
    }

    public function reject(Leave $leave)
    {
        $leave->update(['status_pengajuan' => 'rejected']);
        return back()->with('success', 'Leave rejected successfully');
    }

    public function export(Request $request)
    {
        $query = Leave::with('user');

        if ($search = $request->search) {
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$search}%"));
        }
        if ($request->type) {
            $query->where('tipe_cuti', $request->type);
        }
        if ($request->status) {
            $query->where('status_pengajuan', $request->status);
        }

        $leaves = $query->latest()->get();

        $filename = 'leaves-export-' . now()->format('Y-m-d') . '.csv';

        return response()->stream(function () use ($leaves) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['Employee', 'Type', 'Start Date', 'End Date', 'Reason', 'Status']);
            foreach ($leaves as $l) {
                fputcsv($handle, [
                    $l->user->nama_lengkap ?? 'N/A',
                    $l->tipe_cuti ?? '',
                    $l->tanggal_mulai ? $l->tanggal_mulai->format('d M Y') : '',
                    $l->tanggal_selesai ? $l->tanggal_selesai->format('d M Y') : '',
                    $l->alasan ?? '',
                    $l->status_pengajuan ?? '',
                ]);
            }
            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
