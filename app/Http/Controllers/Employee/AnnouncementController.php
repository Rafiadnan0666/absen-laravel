<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()
            ->paginate(10);

        return view('employee.announcements.index', compact('announcements'));
    }

    public function show(Announcement $announcement)
    {
        return view('employee.announcements.show', compact('announcement'));
    }
}
