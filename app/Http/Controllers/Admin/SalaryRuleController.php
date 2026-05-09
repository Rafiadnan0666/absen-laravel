<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SalaryRule;
use Illuminate\Http\Request;

class SalaryRuleController extends Controller
{
    public function index()
    {
        $salaryRules = SalaryRule::paginate(10);
        return view('admin.salary-rules.index', compact('salaryRules'));
    }

    public function create()
    {
        return view('admin.salary-rules.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_gaji' => 'required|in:hourly,daily,monthly',
            'rate_lembur' => 'required|numeric|min:0',
            'penalti_telat_per_menit' => 'required|numeric|min:0',
            'penalti_tidak_hadir' => 'required|numeric|min:0',
        ]);

        SalaryRule::create($validated);
        return redirect()->route('admin.salary-rules.index')->with('success', 'Salary Rule created');
    }

    public function show(SalaryRule $salaryRule)
    {
        return view('admin.salary-rules.show', compact('salaryRule'));
    }

    public function edit(SalaryRule $salaryRule)
    {
        return view('admin.salary-rules.edit', compact('salaryRule'));
    }

    public function update(Request $request, SalaryRule $salaryRule)
    {
        $validated = $request->validate([
            'tipe_gaji' => 'required|in:hourly,daily,monthly',
            'rate_lembur' => 'required|numeric|min:0',
            'penalti_telat_per_menit' => 'required|numeric|min:0',
            'penalti_tidak_hadir' => 'required|numeric|min:0',
        ]);

        $salaryRule->update($validated);
        return redirect()->route('admin.salary-rules.index')->with('success', 'Salary Rule updated');
    }

    public function destroy(SalaryRule $salaryRule)
    {
        $salaryRule->delete();
        return redirect()->route('admin.salary-rules.index')->with('success', 'Salary Rule deleted');
    }
}
