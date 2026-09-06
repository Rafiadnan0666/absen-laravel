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
        $query = Leave::with('user', 'approvedBy');

        if ($request->filled('date_from')) {
            $query->whereDate('tanggal_mulai', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('tanggal_selesai', '<=', $request->date_to);
        }
        if ($request->filled('status')) {
            $query->where('status_pengajuan', $request->status);
        }
        if ($request->filled('tipe_cuti')) {
            $query->where('tipe_cuti', $request->tipe_cuti);
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $users = User::where('status_akun', 'active')->orderBy('nama_lengkap')->get();

        $leaves = $query->latest('tanggal_mulai')->paginate(20)->withQueryString();
        return view('admin.leaves.index', compact('leaves', 'users'));
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
}
