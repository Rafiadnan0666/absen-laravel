<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index()
    {
        $holidays = Holiday::orderBy('tanggal')->paginate(10);
        return view('admin.holidays.index', compact('holidays'));
    }

    public function create()
    {
        return view('admin.holidays.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_hari_libur' => 'required|string|max:255',
            'tanggal' => 'required|date|unique:holidays,tanggal',
        ]);

        Holiday::create($validated);
        return redirect()->route('admin.holidays.index')->with('success', 'Holiday created');
    }

    public function show(Holiday $holiday)
    {
        return view('admin.holidays.show', compact('holiday'));
    }

    public function edit(Holiday $holiday)
    {
        return view('admin.holidays.edit', compact('holiday'));
    }

    public function update(Request $request, Holiday $holiday)
    {
        $validated = $request->validate([
            'nama_hari_libur' => 'required|string|max:255',
            'tanggal' => 'required|date|unique:holidays,tanggal,' . $holiday->id,
        ]);

        $holiday->update($validated);
        return redirect()->route('admin.holidays.index')->with('success', 'Holiday updated');
    }

    public function destroy(Holiday $holiday)
    {
        $holiday->delete();
        return redirect()->route('admin.holidays.index')->with('success', 'Holiday deleted');
    }
}
