<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\OvertimeRule;
use Illuminate\Http\Request;

class OvertimeRuleController extends Controller
{
    public function index()
    {
        $overtimeRules = OvertimeRule::paginate(10);
        return view('admin.overtime-rules.index', compact('overtimeRules'));
    }

    public function create()
    {
        return view('admin.overtime-rules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'minimal_jam' => 'required|numeric|min:0',
            'multiplier' => 'required|numeric|min:0',
        ]);

        OvertimeRule::create($validated);
        return redirect()->route('admin.overtime-rules.index')->with('success', 'Overtime Rule created');
    }

    public function show(OvertimeRule $overtimeRule)
    {
        return view('admin.overtime-rules.show', compact('overtimeRule'));
    }

    public function edit(OvertimeRule $overtimeRule)
    {
        return view('admin.overtime-rules.edit', compact('overtimeRule'));
    }

    public function update(Request $request, OvertimeRule $overtimeRule)
    {
        $validated = $request->validate([
            'minimal_jam' => 'required|numeric|min:0',
            'multiplier' => 'required|numeric|min:0',
        ]);

        $overtimeRule->update($validated);
        return redirect()->route('admin.overtime-rules.index')->with('success', 'Overtime Rule updated');
    }

    public function destroy(OvertimeRule $overtimeRule)
    {
        $overtimeRule->delete();
        return redirect()->route('admin.overtime-rules.index')->with('success', 'Overtime Rule deleted');
    }
}
