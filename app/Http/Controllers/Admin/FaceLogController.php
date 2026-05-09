<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaceLog;
use Illuminate\Http\Request;

class FaceLogController extends Controller
{
    public function index()
    {
        $faceLogs = FaceLog::with('user')->latest()->paginate(20);
        return view('admin.face-logs.index', compact('faceLogs'));
    }

    public function show(FaceLog $faceLog)
    {
        return view('admin.face-logs.show', compact('faceLog'));
    }

    public function destroy(FaceLog $faceLog)
    {
        $faceLog->delete();
        return redirect()->route('admin.face-logs.index')->with('success', 'Face Log deleted');
    }
}
