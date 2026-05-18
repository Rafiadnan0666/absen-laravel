<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('user', 'approver');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"));
        }

        if ($request->filled('filterStatus')) {
            $query->where('status_pengajuan', $request->filterStatus);
        }

        if ($request->filled('filterType')) {
            $query->where('tipe_cuti', $request->filterType);
        }

        if ($request->filled('dateFrom')) {
            $query->whereDate('tanggal_mulai', '>=', $request->dateFrom);
        }

        if ($request->filled('dateTo')) {
            $query->whereDate('tanggal_selesai', '<=', $request->dateTo);
        }

        $leaves = $query->latest('tanggal_mulai')->paginate(20)->withQueryString();

        if ($request->ajax()) {
            return view('admin.leaves._table', compact('leaves'))->render();
        }

        $totalLeaves = Leave::count();
        $pendingCount = Leave::where('status_pengajuan', 'pending')->count();
        $approvedCount = Leave::where('status_pengajuan', 'approved')->count();
        $rejectedCount = Leave::where('status_pengajuan', 'rejected')->count();

        return view('admin.leaves.index', compact(
            'leaves', 'totalLeaves', 'pendingCount', 'approvedCount', 'rejectedCount'
        ));
    }

    public function create()
    {
        $users = User::where('status_akun', 'active')->get();
        return view('admin.leaves.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipe_cuti' => 'required|in:sick,annual,unpaid',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
        ]);

        $validated['status_pengajuan'] = 'pending';
        Leave::create($validated);
        return redirect()->route('admin.leaves.index')->with('success', 'Leave created');
    }

    public function show(Leave $leave)
    {
        return view('admin.leaves.show', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        $users = User::where('status_akun', 'active')->get();
        return view('admin.leaves.edit', compact('leave', 'users'));
    }

    public function update(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'tipe_cuti' => 'required|in:sick,annual,unpaid',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string',
            'status_pengajuan' => 'required|in:pending,approved,rejected',
        ]);

        if ($validated['status_pengajuan'] !== $leave->status_pengajuan && $validated['status_pengajuan'] !== 'pending') {
            $validated['approved_by'] = auth()->id();
        }

        $leave->update($validated);
        return redirect()->route('admin.leaves.index')->with('success', 'Leave updated');
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();
        return redirect()->route('admin.leaves.index')->with('success', 'Leave deleted');
    }

    public function approve(Leave $leave)
    {
        $leave->update([
            'status_pengajuan' => 'approved',
            'approved_by' => auth()->id(),
        ]);
        return redirect()->route('admin.leaves.index')->with('success', 'Leave approved');
    }

    public function reject(Leave $leave)
    {
        $leave->update([
            'status_pengajuan' => 'rejected',
            'approved_by' => auth()->id(),
        ]);
        return redirect()->route('admin.leaves.index')->with('success', 'Leave rejected');
    }

    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.leaves.index')->with('error', 'No items selected');
        }

        Leave::whereIn('id', $ids)->where('status_pengajuan', 'pending')
            ->update(['status_pengajuan' => 'approved', 'approved_by' => auth()->id()]);

        return redirect()->route('admin.leaves.index')->with('success', count($ids) . ' leaves approved');
    }

    public function bulkReject(Request $request)
    {
        $ids = $request->input('ids', []);
        if (empty($ids)) {
            return redirect()->route('admin.leaves.index')->with('error', 'No items selected');
        }

        Leave::whereIn('id', $ids)->where('status_pengajuan', 'pending')
            ->update(['status_pengajuan' => 'rejected', 'approved_by' => auth()->id()]);

        return redirect()->route('admin.leaves.index')->with('success', count($ids) . ' leaves rejected');
    }

    public function export(Request $request)
    {
        $query = Leave::with('user', 'approver');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%"));
        }
        if ($request->filled('filterStatus')) {
            $query->where('status_pengajuan', $request->filterStatus);
        }
        if ($request->filled('filterType')) {
            $query->where('tipe_cuti', $request->filterType);
        }
        if ($request->filled('dateFrom')) {
            $query->whereDate('tanggal_mulai', '>=', $request->dateFrom);
        }
        if ($request->filled('dateTo')) {
            $query->whereDate('tanggal_selesai', '<=', $request->dateTo);
        }

        $leaves = $query->latest('tanggal_mulai')->get();

        $filename = 'leaves-export-' . now()->format('Y-m-d-His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $callback = function () use ($leaves) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, "\xEF\xBB\xBF");
            fputcsv($handle, ['ID', 'Employee', 'Type', 'Start Date', 'End Date', 'Reason', 'Status', 'Approved By']);

            foreach ($leaves as $l) {
                fputcsv($handle, [
                    $l->id,
                    $l->user->nama_lengkap ?? 'N/A',
                    $l->tipe_cuti,
                    $l->tanggal_mulai->format('Y-m-d'),
                    $l->tanggal_selesai->format('Y-m-d'),
                    $l->alasan,
                    $l->status_pengajuan,
                    $l->approver->nama_lengkap ?? '-',
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
