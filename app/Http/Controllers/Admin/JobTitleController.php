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
        ]);

        JobTitle::create($validated);
        return redirect()->route('admin.job-titles.index')->with('success', 'Job Title created');
    }

    public function show(Request $request, JobTitle $jobTitle)
    {
        $users = $jobTitle->users()->paginate(10);
        return view('admin.job-titles.show', compact('jobTitle', 'users'));
    }

    public function edit(JobTitle $jobTitle)
    {
        return view('admin.job-titles.edit', compact('jobTitle'));
    }

    public function update(Request $request, JobTitle $jobTitle)
    {
        $validated = $request->validate([
            'nama_jabatan' => 'required|string|max:255|unique:job_titles,nama_jabatan,' . $jobTitle->id,
            'deskripsi' => 'nullable|string',
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
