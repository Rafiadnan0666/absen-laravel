<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reimbursement;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    public function index(Request $request)
    {
        $query = Reimbursement::with('user:id,nama_lengkap,email', 'approver:id,nama_lengkap');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $reimbursements = $query->latest()->paginate($request->per_page ?? 15);

        return response()->json($reimbursements);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:0',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
        ]);

        $validated['status'] = 'pending';
        $reimbursement = Reimbursement::create($validated);

        return response()->json($reimbursement->load('user'), 201);
    }

    public function show(Reimbursement $reimbursement)
    {
        return response()->json($reimbursement->load('user', 'approver'));
    }

    public function update(Request $request, Reimbursement $reimbursement)
    {
        $validated = $request->validate([
            'status' => 'sometimes|in:pending,approved,rejected',
            'deskripsi' => 'sometimes|string',
            'jumlah' => 'sometimes|numeric|min:0',
        ]);

        if (in_array($validated['status'] ?? '', ['approved', 'rejected'])) {
            $validated['approved_by'] = auth()->id();
        }

        $reimbursement->update($validated);

        return response()->json($reimbursement->load('user', 'approver'));
    }

    public function destroy(Reimbursement $reimbursement)
    {
        $reimbursement->delete();

        return response()->json(['message' => 'Reimbursement deleted']);
    }
}
