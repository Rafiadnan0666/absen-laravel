<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('user:id,nama_lengkap,email', 'approver:id,nama_lengkap');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status_pengajuan', $request->status);
        }

        if ($request->filled('tipe_cuti')) {
            $query->where('tipe_cuti', $request->tipe_cuti);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_mulai', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_selesai', '<=', $request->date_to);
        }

        $leaves = $query->latest('tanggal_mulai')->paginate($request->per_page ?? 15);

        return response()->json($leaves);
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
        $leave = Leave::create($validated);

        return response()->json($leave->load('user'), 201);
    }

    public function show(Leave $leave)
    {
        return response()->json($leave->load('user', 'approver'));
    }

    public function update(Request $request, Leave $leave)
    {
        $validated = $request->validate([
            'status_pengajuan' => 'sometimes|in:pending,approved,rejected',
            'alasan' => 'sometimes|string',
        ]);

        if (in_array($validated['status_pengajuan'] ?? '', ['approved', 'rejected'])) {
            $validated['approved_by'] = auth()->id();
        }

        $leave->update($validated);

        return response()->json($leave->load('user', 'approver'));
    }

    public function destroy(Leave $leave)
    {
        $leave->delete();

        return response()->json(['message' => 'Leave deleted']);
    }
}
