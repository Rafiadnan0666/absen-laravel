<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobTitle;
use Illuminate\Http\Request;

class JobTitleController extends Controller
{
    public function index()
    {
        $jobTitles = JobTitle::withCount('users')->paginate(10);
        return view('admin.job-titles.index', compact('jobTitles'));
    }

    public function create()
    {
        return view('admin.job-titles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'default_gaji' => 'nullable|numeric|min:0',
        ]);

        JobTitle::create($validated);
        return redirect()->route('admin.job-titles.index')->with('success', 'Job Title created');
    }

    public function show(JobTitle $jobTitle)
    {
        $jobTitle->load('users');
        return view('admin.job-titles.show', compact('jobTitle'));
    }

    public function edit(JobTitle $jobTitle)
    {
        return view('admin.job-titles.edit', compact('jobTitle'));
    }

    public function update(Request $request, JobTitle $jobTitle)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'default_gaji' => 'nullable|numeric|min:0',
        ]);

        $jobTitle->update($validated);
        return redirect()->route('admin.job-titles.index')->with('success', 'Job Title updated');
    }

    public function destroy(JobTitle $jobTitle)
    {
        $jobTitle->delete();
        return redirect()->route('admin.job-titles.index')->with('success', 'Job Title deleted');
    }
}
