<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::where('user_id', auth()->id());

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

        $leaves = $query->latest()->paginate(10)->withQueryString();

        return view('employee.leaves.index', compact('leaves'));
    }

    public function create()
    {
        return view('employee.leaves.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_cuti' => 'required|in:sick,annual,unpaid',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
        ]);

        Leave::create([
            'user_id' => auth()->id(),
            'tipe_cuti' => $request->tipe_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
            'status_pengajuan' => 'pending',
        ]);

        return redirect()->route('employee.leaves.index')
            ->with('success', 'Leave request submitted successfully!');
    }

    public function show(Leave $leave)
    {
        if ($leave->user_id !== auth()->id()) {
            abort(403);
        }

        return view('employee.leaves.show', compact('leave'));
    }

    public function edit(Leave $leave)
    {
        if ($leave->user_id !== auth()->id()) {
            abort(403);
        }

        if ($leave->status_pengajuan != 'pending') {
            return redirect()->route('employee.leaves.index')
                ->with('error', 'Cannot edit leave that is already processed.');
        }

        return view('employee.leaves.edit', compact('leave'));
    }

    public function update(Request $request, Leave $leave)
    {
        if ($leave->user_id !== auth()->id()) {
            abort(403);
        }

        if ($leave->status_pengajuan != 'pending') {
            return redirect()->route('employee.leaves.index')
                ->with('error', 'Cannot edit leave that is already processed.');
        }

        $request->validate([
            'tipe_cuti' => 'required|in:sick,annual,unpaid',
            'tanggal_mulai' => 'required|date|after_or_equal:today',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'alasan' => 'required|string|max:500',
        ]);

        $leave->update([
            'tipe_cuti' => $request->tipe_cuti,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
            'alasan' => $request->alasan,
        ]);

        return redirect()->route('employee.leaves.index')
            ->with('success', 'Leave request updated successfully!');
    }

    public function destroy(Leave $leave)
    {
        if ($leave->user_id !== auth()->id()) {
            abort(403);
        }

        if ($leave->status_pengajuan !== 'pending') {
            return redirect()->route('employee.leaves.index')
                ->with('error', 'Cannot cancel leave that is already processed.');
        }

        $leave->delete();

        return redirect()->route('employee.leaves.index')
            ->with('success', 'Leave request cancelled successfully!');
    }
}
