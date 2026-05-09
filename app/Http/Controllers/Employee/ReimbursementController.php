<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Reimbursement;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    public function index()
    {
        $reimbursements = Reimbursement::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('employee.reimbursements.index', compact('reimbursements'));
    }

    public function create()
    {
        return view('employee.reimbursements.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
            'deskripsi' => 'required|string|max:500',
        ]);

        Reimbursement::create([
            'user_id' => auth()->id(),
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
            'status' => 'pending',
        ]);

        return redirect()->route('employee.reimbursements.index')
            ->with('success', 'Reimbursement request submitted successfully!');
    }

    public function show(Reimbursement $reimbursement)
    {
        if ($reimbursement->user_id !== auth()->id()) {
            abort(403);
        }

        return view('employee.reimbursements.show', compact('reimbursement'));
    }

    public function edit(Reimbursement $reimbursement)
    {
        if ($reimbursement->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reimbursement->status != 'pending') {
            return redirect()->route('employee.reimbursements.index')
                ->with('error', 'Cannot edit reimbursement that is already processed.');
        }

        return view('employee.reimbursements.edit', compact('reimbursement'));
    }

    public function update(Request $request, Reimbursement $reimbursement)
    {
        if ($reimbursement->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reimbursement->status != 'pending') {
            return redirect()->route('employee.reimbursements.index')
                ->with('error', 'Cannot edit reimbursement that is already processed.');
        }

        $request->validate([
            'jumlah' => 'required|numeric|min:1000',
            'deskripsi' => 'required|string|max:500',
        ]);

        $reimbursement->update([
            'jumlah' => $request->jumlah,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('employee.reimbursements.index')
            ->with('success', 'Reimbursement request updated successfully!');
    }

    public function destroy(Reimbursement $reimbursement)
    {
        if ($reimbursement->user_id !== auth()->id()) {
            abort(403);
        }

        if ($reimbursement->status !== 'pending') {
            return redirect()->route('employee.reimbursements.index')
                ->with('error', 'Cannot cancel reimbursement that is already processed.');
        }

        $reimbursement->delete();

        return redirect()->route('employee.reimbursements.index')
            ->with('success', 'Reimbursement request cancelled successfully!');
    }
}
