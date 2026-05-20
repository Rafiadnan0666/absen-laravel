<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OnboardingController extends Controller
{
    public function complete(Request $request)
    {
        $user = $request->user();
        $user->update(['onboarding_completed_at' => now()]);

        if ($request->wantsJson()) {
            return response()->json(['status' => 'ok']);
        }

        return back()->with('success', 'Onboarding completed!');
    }

    public function skip(Request $request)
    {
        $request->session()->forget('show_tour');

        return back();
    }
}
